<template>
    <div>
        <div class="userSection">
    <div class="d-flex justify-content-between flex-wrap align-items-center py-4">
        <div class="titleBox">
            <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Promotional Codes</h3>
        </div>
        <div class="addPackages text-md-right">
              <router-link :to="{name : 'admin.promos.create'}">ADD Code</router-link>
        </div>
    </div>
    <!-- {{admins}} -->
     <div class="notification-section shadow p-5 rounded-15 my-4">
        <div class="row">
            <div class="col-md-12 pt-5 table-responsive">
                <Table @page-changed="fetch" :fields="tableFields"  :data="promotionals">
                    <table-search 
                        show-status
                        show-date-ranges
                         @on-change-status="setCallback('currentStatus',$event,fetch)"
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
                                        <router-link :to="{ name : 'admin.promos.show',params : {id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-eye table-eye pr-2 "></i>View</router-link>
                                          <router-link :to="{ name : 'admin.promos.edit',params : {id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-pencil-square pr-2 "></i>Edit</router-link>
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
        <confirm el="delete-modal" @confirmed="deleteEntity"  title="System Message" :subtitle="`Are you sure you want to delete this Admin? `"></confirm>
    </div>
</template>


<script>
import { mapActions, mapState } from 'vuex';
export default {
    computed: {
      ...mapState('admin', ['promotionals']),
        tableFields(){
                return [
                    {
                        label : 'Promo Code Name',
                        key : 'name',

                    },
                    {
                        label : 'Promo Code',
                        key : 'promo_code',
                        
                    },
                    {
                        label : 'Created On',
                        key : 'created_at',
                        format : this.formatDate,
                        
                    },
                    {
                        label : 'Status',
                        key : 'status_detail',                       
                    },
                ]
        },
    },
    components: {
    },
    data() {
        return {
            promotional : {},
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
       ...mapActions('admin', ['getAll','delete']),
       async fetch(page = 1) {
            let { status } = this.$route.params;
            let params = {
                route: route('admin.promotionals.index'),
                mutation: 'SET_PROMOTIONALS',
                variable: 'promotionals',
                data: {
                    page,
                    status: this.currentStatus,
                    search : this.search,
                       entries : this.entries,
                    dateFrom: this.dateFrom,
                    dateTill: this.dateTill,
                }
            };
            let { data } = await this.getAll(params);
            if (page != 1) {
                this.addRouteQuery({ page });
            } else {

                this.addRouteQuery({});
            }
        },
         async deleteEntity() {
            let params = {
                route: route('admin.admin.destroy', { admin: this.adminId }),
                mutation: 'DELETE_ADMIN',
                variable: 'data',
                data: {},
            };
            let { data } = await this.delete(params);
            if (data.status) {
                this.$snotify.success(data.msg);

            } else {

                this.$snotify.error(data.msg);
            }
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