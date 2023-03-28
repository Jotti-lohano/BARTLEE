<template>
<div class="userSection packages">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Challenges</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="flex-grow-1 text-right">
                <div class="dropdown">
                    <button class="btn dropdown-toggle border pr-3 py-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Add Challenges
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <router-link class="dropdown-item" :to="{name : 'admin.challenges.create',params : {type : 'simple'}}">Simple Challange</router-link>
                        <router-link class="dropdown-item" :to="{name : 'admin.challenges.create',params : {type : 'request'}}">Complex Challange</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="contentBox registerdUser border my-3">
                <div class="d-flex jusify-content-between flex-wrap flex-lg-nowrap align-items-center">
                    <p class="flex-grow-1 mb-0">Smiles from Businesses</p>
                    <select class="form-select form-select-sm pr-5 py-2 w-auto" aria-label=".form-select-sm example">
                        <option selected>Today</option>
                        <option value="1">January</option>
                        <option value="2">Febuary</option>
                        <option value="3">March</option>
                    </select>
                </div>
                <div class="contentStats h-100">
                    <h3 class="h1">3702</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="contentBox registerdUser border my-3">
                <div class="d-flex jusify-content-between flex-wrap flex-lg-nowrap align-items-center">
                    <p class="flex-grow-1 mb-0">Smiles Users Have</p>
                    <select class="form-select form-select-sm pr-5 py-2 w-auto" aria-label=".form-select-sm example">
                        <option selected>Today</option>
                        <option value="1">January</option>
                        <option value="2">Febuary</option>
                        <option value="3">March</option>
                    </select>
                </div>
                <div class="contentStats h-100">
                    <h3 class="h1">4265</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="notification-section shadow p-5 rounded-15 my-4">
        <ul class="nav nav-tabs d-flex flex-wrap justify-content-center align-items-center gap-15 border-0 text-center" id="myTab" role="tablist">
            <li class="nav-item flex-grow-1 shadow border-0">
                <a @click="changePreview('challenges')" :class="{active : (!$route.params.type)}" class="nav-link"  id="business-tab" data-toggle="tab" href="javascript:void(0)" role="tab" aria-controls="business" aria-selected="false">Challenges</a>
            </li>
            <li class="nav-item flex-grow-1 shadow border-0">
                <a @click="changePreview('requests','requests')" :class="{active : ($route.params.type == 'requests')}" class="nav-link" id="smiles-tab" data-toggle="tab" href="javascript:void(0)"  role="tab" aria-controls="smiles" aria-selected="false">Requests</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 pt-5 table-responsive">
               <Table :key="refreshTable" @page-changed="fetch" :fields="tableFields" :data="data">
                   <table-search 
                        :show-status="!$route.params.type"
                        show-date-ranges
                        :statuses="statusesList"
                        @on-search="setCallback('search',$event,fetch)"
                        @on-change-date-to="setCallback('dateTill',$event,fetch)"
                        @on-change-date-from="setCallback('dateFrom',$event,fetch)"
                        @on-change-entries="setCallback('entries',$event,fetch)"
                        @on-change-status="setCallback('status',$event,fetch)"
                   />
                   <template slot="extra-cells" slot-scope="item">
                       <td>
                            <div class="btn-group ml-1">
                                <button type="button" class="btn border-color outline-0" data-toggle="dropdown" aria-expanded="false"> <i class="bi bi-three-dots-vertical"></i> </button>
                                <div class="dropdown-menu">
                                    <a v-if="!$route.params.type" href="javascript:void(0)" @click="changeStatus(item.id)" class="dropdown-item mb-1">{{item.status == 'active'? 'Inactive':'Active'}}</a>
                                    <router-link :to="{ name : 'admin.challenges.show',params : {type : (!$route.params.type?'challenge':'request'),id : item.id} }" class="dropdown-item mb-1"><i class="bi bi-eye table-eye pr-2 "></i>View</router-link>
                                </div>
                            </div>
                        </td>
                   </template>
               </Table>
            </div>
        </div>
    </div>
    <!-- <div class="titleBox py-4">
        <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Complex Challange Requests</h3>
    </div> -->
    <div class="notification-section shadow p-5 rounded-15 my-4">
        <!-- <div class="row justify-content-between">
            <div class="col-md-12 mb-3">
                <div class="filterOption">
                    <div class="title">
                        <h3 class="h5 achivpFont">Sort By:</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center flex-wrap mb-3">
                    <div class="dateBox d-flex align-items-center gap-15">
                        <p class="mb-0 achivpFont">Form:</p>
                        <div class="flex-grow-1">
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker7" data-target-input="nearest">
                                    <input type="date" class="form-control datetimepicker-input" data-target="#datetimepicker7" />
                                </div>
                            </div>
                        </div>
                        -
                        <div class="flex-grow-1">
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                                    <input type="date" class="form-control datetimepicker-input" data-target="#datetimepicker8" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="selectBox">
                    <div class="grapSelect d-flex gap-15 align-items-center flex-wrap flex-lg-nowrap">
                        <p class="mb-0 achivpFont">Show:</p>
                        <select class="form-select form-select-sm pr-5 py-2 w-auto" aria-label=".form-select-sm example">
                            <option selected>Record Per Page</option>
                            <option value="1">10</option>
                            <option value="2">20</option>
                            <option value="3">30</option>
                        </select>
                        <p class="mb-0">Entries</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="userSeach input-group w-auto">
                    <input class="form-control w-50 py-2 border-right-0 border" type="search" placeholder="Search Cities" id="example-search-input">
                    <span class="input-group-append">
                        <button class="btn btn-outline-secondary border-left-0 border bg-white" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div> -->
    </div>
</div>    
</template>
<script>
import { mapActions } from 'vuex';
export default {
    computed : {
        tableFields(){
            if(!this.$route.params.type)
            return [{
                key  : 'challenge_name',
                label  : 'Challenge Name',
            },{
                key  : 'business',
                label  : 'Business Name',
                format : (detail)=> {
                    return detail?detail.business_name?detail.business_name:'No name':'No name';
                },
            },{
                key  : 'challenge_type',
                label  : 'type',
            },{
                key  : 'created_at',
                label  : 'Created On',
                format : this.formatDate,
            },{
                key  : 'status',
                label  : 'Status',
            }];

            return [{
                key  : 'challenge_name',
                label  : 'Challenge Name',
            },{
                key  : 'business',
                label  : 'Business Name',
                format : (detail)=> {
                    return detail?detail.business_name?detail.business_name:'No name':'No name';
                },
            },{
                key  : 'created_at',
                label  : 'Requested On',
                format : this.formatDate,
            }];
        },
    },
    data: ()=> ({
        data : {},
        search : null,
        status : null,
        entries : 10,
        dateTill : '',
        dateFrom : '',
        type : 'challenges',
        refreshTable : 0,
        statusesList : [{
                label : 'Active',
                value : 'active',
            },{
                label : 'Past',
                value : 'past',
            }],
    }),
    async mounted(){
        this.type = this.$route.params.type?'requests':'challenges';
        await this.fetch();
    },
    methods : {
        ...mapActions('admin',['getAll','set']),
        changePreview(componentName, value = null){
            this.$router.push({name : 'admin.challenges.index',params : {type : value}});
            this.componentName = componentName;
        },
        async changeStatus(id){
            try {
                let fd = new FormData();
                
                fd.append('type','challenges');
                let {data} = await this.set({
                    route : route('admin.challenges.update',{challenge : id}),
                    method : 'PUT',
                    data : fd,
                });
                if(data.status){
                    let index = this.data.data.findIndex((item)=>item.id == id);
                    Vue.set(this.data.data,index,data.data); 
                    // this.refreshTable++;
                    // this.data.data[index].status =='active'? 'inactive' : 'active';
                    this.$snotify.success(data.msg);
                }
            } catch (error) {
                console.log(error);
                if(error){
                    console.log(error);
                }
            }
        },
        async fetch(page = 1){
            let {data} = await this.getAll({
                route : route('admin.challenges.index'),
                data : {
                    page,
                    search : this.search,
                    dateTill : this.dateTill,
                    dateFrom : this.dateFrom,   
                    entries : this.entries,                 
                    type : this.type,
                    status : this.status,

                },
            });
            this.data = data.data;
        },
    },
}
</script>