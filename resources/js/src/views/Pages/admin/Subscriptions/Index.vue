<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <!-- Basic form layout section start -->
        <section id="subscription_manage" class="subscription-page">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12">
                        <h2>Subscription Logs</h2>
                    </div>
                </div>
            </div>
            <div class="content-body bg-white rounded-10 shadow-sm p-4 p-lg-5">
                <div class="dataTables_wrapper">
                    <div class="user-listing-top">
                        <div class="row align-items-end d-flex mb-3">
                            <div class="col-12 col-xl-7 col-xxl-8 mt-md-0 sort-datepicker d-block d-lg-flex align-items-end mb-3 mb-xl-0">
                                <label class="me-2 mb-0 pb-1 mb-lg-2 d-block flex-shrink-0">Sort By</label>
                                <div class="d-sm-flex d-block flex-grow-1">
                                    <div class="input-wrap me-0 me-sm-2 mb-2 mb-sm-0">
                                        <label for="" class="fw-regular">From</label>
                                        <input v-model="fromDate" type="date" placeholder="From" class="form-control">
                                    </div>
                                    <div class="input-wrap">
                                        <label for="" class="fw-regular">To</label>
                                        <input v-model="toDate" type="date" placeholder="To" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-5 col-xxl-4 align-items-center">
                                <div class="dataTables_filter d-flex justify-content-start flex-shrink-1">
                                    <label for="" class="d-none d-md-inline-block me-2 me-lg-3 my-0 align-self-center flex-shrink-0 fw-light">Search</label>
                                    <div class="search-wrap flex-grow-1">
                                        <input v-model="search" type="search" class="form-control" placeholder="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mt-2 mt-md-0 align-self-xl-end">
                                <div class="dataTables_length order_select d-block d-md-flex align-items-center">
                                    <label class="d-inline-md-block d-block me-4">Show</label>
                                    <div class="d-block d-md-flex">
                                        <div class="select-wrapper  d-block d-inline-md-block w-auto">
                                            <select v-model="entries" class="form-control d-inline-block">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mt-2 mt-md-0">
                                <div class="filter-wrap d-md-flex d-block flex-xl-column align-items-start align-items-xl-end justify-content-end">
                                    <div class="select-wrapper d-block w-auto mb-0 mb-md-0 me-0 me-md-0 me-xl-0">
                                        <select name="" v-model="status" class="form-control" id="">
                                            <option value="">Choose Status</option>
                                            <option value="active">Active</option>
                                            <option value="expire">Expire</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-tabble table-responsive mx-n2">
                        <table class="table table-borderless dataTable px-2">
                            <thead>
                                <tr>
                                    <th class="sorting">Sr. No.</th>
                                    <th class="sorting">Username</th>
                                    <th class="sorting">Customer Email</th>
                                    <th class="sorting">start Date</th>
                                    <th class="sorting">Expiry Date</th>
                                    <th class="sorting">Subscription Plan</th>
                                    <th class="sorting">Amount Paid</th>
                                    <th class="sorting">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(subscription,index) in subscriptions.data" :key="index">
                                    <td>{{++index}}</td>
                                    <td>{{subscription.subscriber != null ? (subscription.subscriber.first_name+' ' +subscription.subscriber.last_name) : 'Not Found!'}}</td>
                                    <td>{{subscription.subscriber != null ? subscription.subscriber.email : 'Not Found!'}}</td>
                                    <td>{{subscription.purchase_date | newFormatDate}} </td>
                                    <td>{{subscription.expire_date | newFormatDate}}</td>
                                    <td>{{subscription.package.package_name}}</td>
                                    <td>AED {{subscription.package.package_amount}}</td>
                                    <td>{{subscription.status.toUpperCase()}}</td>
                                </tr>
                           <no-record tag="tr" :colspan="8" :data="subscriptions.data" class="col-md-3"></no-record>

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-xxl-5 align-self-center text-center text-xxl-start">
                            <div class="dataTables_info pl-2">Showing {{subscriptions.to}} of {{subscriptions.total}} entries</div>
                        </div>
                        <div class="col-sm-12 col-xxl-7 d-flex justify-content-center justify-content-xxl-end">
                            <div class="dataTables_paginate">
                                <ul class="pagination">
                                  <pagination :data="subscriptions" @pagination-change-page="fetch"></pagination>     
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</template>


<script>
import { mapActions, mapState } from 'vuex';
export default {
    components: {
    },
    data() {
        return {
            subscriptions : {},
            type : '',
            entries : 10,
            search : null,
            form:{
                medicine_type:'',
                medicine_volume:''
            },
            popupMsg: '',
            updatingStatus: "",
            confirmation_popupMsg: "",
            status:'',
            fromDate:'',
            toDate:''
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
        status: function(val, oldVal) {
            this.fetch();
        },
        fromDate: function(val, oldVal) {
            this.fetch();
        },
        toDate: function(val, oldVal) {
            this.fetch();
        },

    },
    methods: {
        ...mapActions('admin', ['getAll','store','manageStatusMed']),
        async fetch(page = 1) {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.users.subscriptions'),
                data: {
                    page,
                    type,
                    status: this.status,
                    search : this.search,
                    entries : this.entries,
                    type : this.type,
                    fromDate:this.fromDate,
                    toDate:this.toDate
                }
            };
            let { data } = await this.getAll(params);
           
            this.subscriptions = data.subscriptions;
             console.log( this.subscriptions)
           
        },
           async create(){
            try {
                let fd = new FormData();
                this.buildFormData(fd,this.form);
                let {data} = await this.store({
                    route : route('admin.users.medicine'),
                    method: 'POST',
                    data: fd,
                });
                if(data.status){
                    this.$snotify.success(data.msg);
                    
                     this.form.medicine_type = '';
                     this.form.medicine_volume='';
                     this.fetch();
                    // this.$router.push({ name: 'admin.packages.index',params : {type : 'plans'} });
                }
            } catch (error) {
                let {errors,msg} = error.response.data 
                if(error.status != 200){
                    this.errorMessage = 'something went wrong';
                }
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
        },
            changeStatusPopUp(user, status){
            $('#activate-user-modal').modal('show');

            if(status == 'inactive'){
                this.popupMsg =  'Are you sure you want to mark as In-Active?';
                this.updatingStatus = "0";
            }else{
                this.popupMsg = 'Are you sure you want to mark as Active?';
                this.updatingStatus = "1";
            }
            this.editUser = {};
            this.editUser = user;
        },
          async changeStatus(){

            let users = this.editUser;
            let { data } = await this.manageStatusMed({userId: users.id, status: this.updatingStatus});
            if(data.status){
                 this.fetch();
                var index = await _.findIndex(this.users.data, function(o) { return o.id == users.id; });
                this.users.data[index]['status'] = data.status;
            }
            if(this.updatingStatus == "1"){
                this.confirmation_popupMsg = 'Active Successfully!';
            }else{
                this.confirmation_popupMsg = 'Inactive Successfully!';
            }
            $('#activated-user-modal').modal('show');
            setTimeout(()=>{
                $('#activated-user-modal').modal('hide');
            }, 1500);
        },
    }
}

</script>