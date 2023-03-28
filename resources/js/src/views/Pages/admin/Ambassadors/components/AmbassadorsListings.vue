<template>
    <div>
        <div class="titleBox py-4">
        <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Ambassadors</h3>
    </div>
    <div class="notification-section shadow p-5 rounded-15 my-4">
        <div class="row">
            <div class="col-md-12 pt-5 table-responsive">
                <Table @page-changed="fetch" :fields="tableFields" :data="ambassadors">
                    <table-search 
                        show-status
                        show-date-ranges
                        @on-search="setCallback('search',$event,fetch)"
                        @on-change-entries="setCallback('entries',$event,fetch)"
                        @on-change-status="setCallback('currentStatus',$event,fetch)"
                        @on-change-date-from="setCallback('dateFrom',$event,fetch)"
                        @on-change-date-to="setCallback('dateTill',$event,fetch)"
                    />
                     <template slot="extra-cells" slot-scope="item">
                        <td>
                                <div class="btn-group ml-1">
                                    <button type="button" class="btn border-color outline-0" data-toggle="dropdown" aria-expanded="false"> <i class="bi bi-three-dots-vertical"></i> </button>
                                    <div class="dropdown-menu">
                                        <router-link :to="{ name : 'admin.ambassadors.show',params : {id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-eye table-eye pr-2 "></i>View</router-link>
                                        <a class="dropdown-item mb-1"><i class="bi bi-x-circle pr-2"></i>In-Active</a>
                                    </div>
                                </div>
                            </td>
                    </template>
                </Table>
               </div>
        </div>
    </div>
    </div>
</template>



<script>
import { mapActions, mapState } from 'vuex';
export default {
    computed: {
        // ...mapState('admin', ['search','entries']),
        tableFields(){
                return [
                    {
                        label : 'User Name',
                        key : 'username',

                    },
                    {
                        label : 'Location',
                        key : 'location',
                        
                    },
                    {
                        label : 'No. Of Business',
                        key : 'num_of_business',
                        
                    },
                    {
                        label : 'Created On',
                        key : 'created_at',
                        format : this.formatDate,
                        
                    },
                    {
                        label : 'status',
                        key : 'status_detail',                       
                    },
                ]
        },
    },
    components: {
    },
    data() {
        return {
            ambassadors : {},
            currentStatus: '',
            dateFrom: '',
            dateTill: '',
            fromDateCheck: false,
            tillDateCheck: false,
            type : '',
            entries : 10,
            search : null,
        };
    },
    created() {
        let { page } = this.$route.query;
        this.fetch(page);
    },
    watch: {
        search: function(val, oldVal) {
            this.fetch();
        },
        entries: function(val, oldVal) {
            this.fetch();
        },
        dateTill(val, oldVal){
            if(val.length > 0){
                this.tillDateCheck = true;
                if(this.fromDateCheck){
                    this.fetch();
                }
            }else{
                this.tillDateCheck = false;
            }
        },
        dateFrom(val, oldVal){
            if(val.length > 0){
                this.fromDateCheck = true;
                if(this.tillDateCheck){
                    this.fetch();
                }
            }else{
                this.fromDateCheck = false;
            }
        }
    },
    methods: {
        ...mapActions('admin', ['getAll']),
        async fetch(page = 1) {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.ambassador.index'),
                // mutation: 'SET_USERS',
                // variable: 'users',
                data: {
                    page,
                    type,
                    status: this.currentStatus,
                    search : this.search,
                    entries : this.entries,
                    dateFrom: this.dateFrom,
                    dateTill: this.dateTill,
                    type : this.type,
                }
            };
            let { data } = await this.getAll(params);
            this.ambassadors = data.ambassadors;
        
            /* if (page != 1) {
                this.addRouteQuery({ page });
            } else {

                this.addRouteQuery({});
            } */
        },
        fetchFilteredData(e){
            this.currentStatus = e.target.value;
            this.fetch();
        },

        clearCalandar(){
            this.dateFrom = '';
            this.dateTill = '';
            this.fetch();
        }
    }
}

</script>