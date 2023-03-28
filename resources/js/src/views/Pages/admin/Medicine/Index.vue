<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <!-- Basic form layout section start -->
        <section id="medicine_manage" class="medicine-manage-page">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12">
                        <h2>Medicine Type Management</h2>
                    </div>
                </div>
            </div>
            <div class="content-body bg-white rounded-10 shadow-sm p-4 p-lg-5">
                <div class="user-listing-top">
                    <div class="row mb-4 mb-md-5">
                        <div class="col-12">
                            <div class="page-title">
                                <h3 class="fw-medium mb-3 mb-lg-5"> Add New Medicine Type</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xxl-5 mb-2 mb-md-0">
                            <validation-observer v-slot="{handleSubmit}" class="col-12">
                             <form @input="errorMessage = null" @submit.prevent="handleSubmit(create)">
                                <div class="row form-group">


                                    <validation-provider tag="div" rules="required|alpha" name="Medicine Type" v-slot="{errors}" class="col-12">
                                    <input type="text" v-model="form.medicine_type" placeholder="Enter Medicine Type" name="Medicine Type" class="form-control">
                                    <div class="text-danger">{{errors[0]}}</div>
                                    </validation-provider>

                                </div>
                                <div class="row form-group">

                                    <validation-provider tag="div" rules="required" name="Potency/Volume" v-slot="{errors}" class="col-12">
                                    <input type="text" v-model="form.medicine_volume" placeholder="Enter Potency/Volume" name="Potency/Volume" class="form-control">
                                    <div class="text-danger">{{errors[0]}}</div>
                                    </validation-provider>


                                </div>
                                <div class="row detail-row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-secondary  px-5">Publish</button>
                                    </div>
                                </div>
                            </form>
                            </validation-observer>

                        </div>
                    </div>
                    <div class="row align-items-end d-flex">
                        <div class="col-12 col-md-4 col-xl-6 col-xxl-8 mt-md-0 sort-datepicker d-block d-xxl-flex align-items-end order-md-1">
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
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mt-3 d-block d-md-flex order-md-3 justify-content-end">
                            <div class="filter-wrap d-md-flex d-block flex-xl-column align-items-start align-items-xl-end justify-content-end">
                                <div class="select-wrapper d-block w-auto mb-0 mb-md-0 me-0 me-md-0 me-xl-0">
                                    <select name="" v-model="type" class="form-control" id="">
                                        <option value="">Choose Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 col-xl-6 col-xxl-4 align-items-center d-flex order-md-2 mt-3 mt-xl-0">
                            <div class="dataTables_filter d-flex justify-content-start flex-grow-1">
                                <label for="" class="d-none d-md-inline-block me-2 me-lg-3 my-0 align-self-center flex-shrink-0 fw-light">Search</label>
                                <div class="search-wrap flex-grow-1">
                                    <input v-model="search" type="search" class="form-control" placeholder="Search">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="dataTables_wrapper">
                    <div class="main-tabble table-responsive mx-n2">
                        <table class="table table-borderless dataTable px-2">
                            <thead>
                                <tr>
                                    <th class="sorting">Sr. No.</th>
                                    <th class="sorting">Medicine Type</th>
                                    <th class="sorting">Potency/Volume</th>
                                    <th class="sorting">Status</th>
                                    <th class="sorting">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(med,index) in medicine.data" :key="index">
                                    <td>{{++index}}</td>
                                    <td>{{med.medicine_type}}</td>
                                    <td>{{med.volume}}</td>
                                    <td>{{med.status == '1' ? 'Active' : 'Inactive'}}</td>
                                    <td>
                                        <div class="btn-group ml-1">
                                            <button type="button" class="btn dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a v-if="med.status == 0" class="dropdown-item" @click="changeStatusPopUp(med, 'active')" data-toggle="modal" data-target=""><i class="fa fa-ban"></i>Active</a>
                                                <a v-else class="dropdown-item mb-1" @click="changeStatusPopUp(med, 'inactive')" data-toggle="modal" data-target=""><i class="fa fa-ban"></i>Inactive</a>
                                                <router-link class="dropdown-item" :to="{name : 'admin.medicine.edit',params : {id : med.id,} }"><i class="fa fa-edit"></i>Edit</router-link>

                                                <!-- <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target=".medicine-inactive"><i class="fa fa-ban"></i>Inactive</a> -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                             <no-record tag="tr" :colspan="5" :data="medicine.data" class="col-md-3"></no-record>

                            </tbody>
                        </table>

                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-xxl-5 align-self-center text-center text-xxl-start">
                            <div class="dataTables_info pl-2"> Showing {{medicine.to}} of {{medicine.total}} entries</div>
                        </div>
                        <div class="col-sm-12 col-xxl-7 d-flex justify-content-center justify-content-xxl-end">
                            <div class="dataTables_paginate">
                                <ul class="pagination">
                                <pagination :data="medicine" @pagination-change-page="fetch"></pagination>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                     <!-- Medicine Updated -->
                    <div class="modal fade medicine-updated p-0" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"></h5>
                                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body px-5">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <i class="fa fa-check-circle mb-3"></i>
                                            <h3 class="modal-title text-center">The record has been successfully updated</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-4 pb-5 text-center d-flex justify-content-center flex-column flex-sm-row align-items-stretch">
                                    <a href="#" data-bs-dismiss="modal" aria-label="Close" class="btn btn-primary">Okay</a>
                                </div>
                            </div>
                        </div>
                    </div>

                       <!-- Active User -->
            <div class="modal fade active-user p-0 active-cat" id="activate-user-modal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                            <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <i class="fa circle-fill fa-question mb-3"></i>
                                    <h3 class="modal-title text-center">{{ popupMsg }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-4 pb-5 text-center d-flex justify-content-center flex-column flex-sm-row align-items-center">
                            <button type="button" class="btn btn-blue mb-sm-0 mb-2 mr-0 mr-sm-1" data-bs-toggle="modal" @click="changeStatus()" data-bs-dismiss="modal" aria-label="Close" data-bs-target=".student-manage-active-confirm">Yes</button>
                            <button type="button" class="btn btn-secondary ml-0 ml-sm-1" data-bs-dismiss="modal" aria-label="Close">No</button>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Inactive User -->
            <div class="modal fade inactive-user p-0 confirm-active-cat" id="activated-user-modal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                            <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <i class="fa fa-check-circle"></i>
                                    <h3 class="modal-title text-center">{{ confirmation_popupMsg }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-4 pb-5 text-center d-flex justify-content-center flex-column flex-sm-row align-items-center">
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
            medicine : {},
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
        type: function(val, oldVal) {
            this.fetch();
        },

    },
    methods: {
        ...mapActions('admin', ['getAll','store','manageStatusMed']),
        async fetch(page = 1) {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.users.medicine'),
                data: {
                    page,
                    type,
                    status: this.currentStatus,
                    search : this.search,
                    entries : this.entries,
                    type : this.type,
                }
            };
            let { data } = await this.getAll(params);
            this.medicine = data.medicine;

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
