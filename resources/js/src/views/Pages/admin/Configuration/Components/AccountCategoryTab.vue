<template>
    <div>
        <div class="tab-pane fade show active" id="business" role="tabpanel" aria-labelledby="business-tab">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Account Category:</h3>
            </div>
            <div class="notification-section shadow p-5 rounded-15 my-4">
                <div class="row">
                    <div class="col-md-12 pt-5 table-responsive">
                           <div class="addPackages text-md-right">
              <router-link :to="{name : 'admin.configuration.create' ,params:{ type:'category'}}">ADD Category</router-link>
        </div>
                    <Table @page-changed="fetch" :fields="tableFields" :data="category">
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
                                          <router-link :to="{ name : 'admin.configuration.edit',params : {type: 'account-category',id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-pencil-square pr-2 "></i>Edit</router-link>
                                       <a class="dropdown-item" href="#" data-toggle="modal" @click="statusModel(item.id ,item.status)" data-target="#change-status"><i class="bi bi-pencil-square pr-2"></i>{{`${item.status == '1' ?'InActive':'Active'}`}}</a>
                                    </div>
                                </div>
                            </td>
                    </template>
                    </Table>
                    </div>
                   
                </div>
            </div>
        </div>
         <confirm el="change-status" @confirmed="updateStatus"  title="System Message" :subtitle="`Are you sure you want to ${changeStatus.status == '1' ?'InActive':'Active'} this Category? `"></confirm>
    </div>
</template>


<script>

import {mapActions} from 'vuex';
export default {
    computed : {
        tableFields(){
            return [
            {
                label : 'Category Name',
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
            ];
        },
    },
    data: ()=> ({
        changeStatus:{
            id:0,
            status:0,
        },
        category : {},
        currentStatus : '',
        search : '',
        entries : 10,
        dateFrom : '',
        dateTill : '',
    }),
    async created(){
        await this.fetch();
    },
    methods : {
        ...mapActions('admin',['getAll' ,'store']),
        async fetch(page = 1) {
			let params = {
				route: route('admin.configuration.category.index',{type: 'package'}),
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
            this.category = data.category;
		},

        async updateStatus() {

            let params = {
                route: route('admin.configuration.category_status'),
                data: {
                    id:this.changeStatus.id,
                     status:this.changeStatus.status,
                }
            };
            try {
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
    },
}
</script>