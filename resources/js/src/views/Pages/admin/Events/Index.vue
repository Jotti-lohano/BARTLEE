<template>
    <div>
        <div class="userSection">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Events</h3>
            </div>
        </div>
    </div>
    <div class="notification-section shadow p-5 rounded-15 my-4">
        <div class="row">
            <div class="col-md-12 pt-5 table-responsive">
                <Table @page-changed="fetch" :fields="tableFields"  :data="events">
                    <table-search 
                        show-date-ranges
                        @on-search="setCallback('search',$event,fetch)"
                        @on-change-entries="setCallback('entries',$event,fetch)"
                        @on-change-date-from="setCallback('dateFrom',$event,fetch)"
                        @on-change-date-to="setCallback('dateTill',$event,fetch)"
                    />
                     <template slot="extra-cells" slot-scope="item">
                        <td>
                                <div class="btn-group ml-1">
                                    <button type="button" class="btn border-color outline-0" data-toggle="dropdown" aria-expanded="false"> <i class="bi bi-three-dots-vertical"></i> </button>
                                    <div class="dropdown-menu">
                                        <router-link :to="{ name : 'admin.events.show',params : {id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-eye table-eye pr-2 "></i>View</router-link>
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
                        label : 'Event Name',
                        key : 'event_name',

                    },
                    {
                        label : 'Business Name',
                        key : 'business_name',
                        
                    },
                    {
                        label : 'Created On',
                        key : 'created_at',
                        format : this.formatDate,
                        
                    },
                    {
                        label : 'No of Saves',
                        key : 'num_of_saved',                       
                    },
                    {
                        label : 'Status',
                        key : 'is_active',                       
                    },
                ]
        },
    },
    components: {
    },
    data() {
        return {
            events : {},
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
                route: route('admin.event.index'),
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
            this.events = data.events;
        
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