<template>
    <div>
        <div class="tab-pane fade show active" id="business" role="tabpanel" aria-labelledby="business-tab">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Stickers:</h3>
            </div>
            <div class="notification-section shadow p-5 rounded-15 my-4">
                <div class="row">
                    <div class="col-md-12 pt-5 table-responsive">
                                  <div class="addPackages text-md-right">
                        <router-link :to="{name : 'admin.configuration.create' ,params:{ type:'stickers'}}">Add Stickers</router-link>
                </div>
                          <Table @page-changed="fetch" :fields="tableFields" :data="stickers">
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
                                          <router-link :to="{ name : 'admin.configuration.show',params : {type: 'stickers',id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-eye table-eye pr-2 "></i>View</router-link>
                                          <router-link :to="{ name : 'admin.configuration.edit',params : {type: 'stickers',id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-pencil-square pr-2 "></i>Edit</router-link>
                                         <a class="dropdown-item" href="#" data-toggle="modal" @click="statusModel(item.id ,item.status)" data-target="#change-status"><i class="bi bi-x-circle pr-2"></i>{{`${item.status == '1' ?'InActive':'Active'}`}}</a>
                                    </div>
                                </div>
                            </td>
                    </template>
                    </Table>
                    </div>
                   
                </div>
            </div>
        </div>
         <confirm el="change-status" @confirmed="updateStatus"  title="System Message" :subtitle="`Are you sure you want to ${changeStatus.status == '1' ?'InActive':'Active'} this Stickers? `"></confirm>
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
                        label : 'Stickers Name',
                        key : 'name',
                    },
                     {
                        label : 'Added On',
                        key : 'created_at',
                        format : this.formatDate,
                    },
                    {
                        label : 'No. Of Business',
                        key : 'num_of_business',
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
            stickers : {},
            currentStatus: '',
            dateFrom: '',
            dateTill: '',
            fromDateCheck: false,
            tillDateCheck: false,
            type : '',
            entries : 10,
            search : null,
            changeStatus:{
            id:0,
            status:0,
        },
        };
    },
    created() {
       
        this.fetch();
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
         ...mapActions('admin', ['getAll' ,'store']),
        async fetch(page = 1) {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.configuration.stickers.index'),
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
            this.stickers = data.stickers;
        },


        fetchFilteredData(e){
            this.currentStatus = e.target.value;
            this.fetch();
        },

        clearCalandar(){
            this.dateFrom = '';
            this.dateTill = '';
            this.fetch();
        },
        async updateStatus() {

            let params = {
                route: route('admin.configuration.stickers_status'),
                data: {
                    id:this.changeStatus.id,
                     status:this.changeStatus.status,
                }
            };

            try 
            {
                let { data } = await this.store(params);
                if (data.status) {
                    this.$snotify.success(data.msg);
                    this.fetch();
                } else {
                    this.$snotify.error('something went wrong');
                }
            } catch (e) {
                if (e.response) {
                       this.$snotify.success(e.response.data.msg);
                }
                console.log(e);
            }
        },
        async statusModel(id ,status ,statusDetail)
        {
            this.changeStatus.id = id; 
            this.changeStatus.status = status; 
        }
    }
}

</script>