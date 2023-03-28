<template>
<div class="app-content content">
    <div class="content-wrapper">
        <!-- Basic form layout section start -->
        <section id="configuration" class="user-page">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12">
                        <h2>
                            <router-link :to="{name : 'admin.users.index'}">
                                <i class="fa fa-chevron-left"></i>
                            </router-link>                                                        
                            View User Profile</h2>
                    </div>
                </div>
            </div>
            <div class="content-body bg-white rounded-10 shadow-sm p-4 p-lg-5 position-relative">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 align-self-center">
                            <h3 class="fw-medium mb-3 mb-lg-5">Profile Details</h3>
                        </div>
                    </div>
                </div>
                <div class="detail-block mb-0 pb-0">
                    <div class="row">
                        <div class="col-12 col-xl-10">
                            <div class="media d-md-flex d-block">
                                <div class="media-left text-center flex-shrink-0 mb-5 mb-lg-0 position-right">
                                    <div class="profile-img text-center m-auto position-relative">
                                        <img :src="detail.user_profile.avatar_url" class="img-fluid ml-0" alt="">
                                    </div>
                                    <!-- <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target=".inactive-user" class="btn btn-secondary px-4 mt-3">Mark as Inactive</a> -->

                                    <a v-if="detail.status == 0" class="btn btn-secondary px-4 mt-3" @click="changeStatusPopUp(detail, 'active')" data-toggle="modal" data-target=""><i class="bi bi-x-circle pr-2"></i>Mark as Active</a>
                                    <a v-else class="btn btn-secondary px-4 mt-3" @click="changeStatusPopUp(detail, 'inactive')" data-toggle="modal" data-target=""><i class="bi bi-x-circle pr-2"></i>Mark as Inactive</a>
                                    
                                    <div class="status fw-light my-4 p-0 d-block">Status: 
                                        <span class="fw-medium">{{detail.status_detail}}</span>
                                        </div>
                                </div>

                                <div class="media-body flex-grow-1 ps-0 mb-3">
                                    <div class="row mb-3 mb-lg-5">
                                        <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                            <label for="">User Type</label>
                                        </div>
                                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                            <p>{{detail.user_subscription_count > 0 ? 'Subscriber' : 'Free User'}}</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mb-lg-5">
                                        <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                            <label for="">First Name</label>
                                        </div>
                                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                            <p>{{detail.user_profile.first_name}}</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mb-lg-5">
                                        <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                            <label for="">Last Name</label>
                                        </div>
                                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                            <p>{{detail.user_profile.last_name}}</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mb-lg-5">
                                        <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                            <label for="">Email</label>
                                        </div>
                                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                            <p>{{detail.user_profile.email}}</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mb-lg-5">
                                        <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                            <label for="">Phone No</label>
                                        </div>
                                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                            <p>{{detail.country_code}} {{detail.phone}}</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mb-lg-5">
                                        <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                            <label for="">Who's the patient :</label>
                                        </div>
                                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                            <p>{{detail.user_type == 'patient' ? 'Me' : 'My Love Once'}}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mb-lg-5">
                                        <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                            <label for="">Gender</label>
                                        </div>
                                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                            <p>{{detail.user_profile.gender}}</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mb-lg-5">
                                        <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                            <label for="">Location:</label>
                                        </div>
                                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                            <p>{{detail.user_profile.location}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="logs-tabs">
                    <ul class="nav nav-pills flex-column flex-sm-row mb-0" id="logs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active w-100" id="pills-medicine-tab" data-bs-toggle="pill" data-bs-target="#pills-medicine" type="button" role="tab" aria-controls="pills-medicine" aria-selected="false">Medicine Log</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="pills-appointment-tab" data-bs-toggle="pill" data-bs-target="#pills-appointment" type="button" role="tab" aria-controls="pills-appointment" aria-selected="true">Appointment Log</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-medicine" role="tabpanel" aria-labelledby="pills-medicine-tab">
                            <div class="dataTables_wrapper pl-0 pr-0">
                                <div class="user-listing-top">
                                    <div class="row mb-4 justify-content-end">
                                        <div class="col-12 col-md-8 col-lg-8 col-xl-6 col-xxl-4 mt-3 mt-lg-0">
                                            <div class="dataTables_filter d-flex justify-content-start flex-shrink-1">
                                                <label for="" class="d-none d-md-inline-block me-2 me-lg-3 my-0 align-self-center flex-shrink-0 fw-light">Search</label>
                                                <div class="search-wrap flex-grow-1">
                                                    <input v-model="medSearch" type="search" class="form-control" placeholder="Search">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-end d-flex mb-3">
                                        <div class="col-12 col-md-8 col-xl-9 col-xxl-8 mt-md-0 d-lg-flex d-block align-items-end sort-datepicker flex-wrap flex-xl-nowrap">
                                            <div class="dataTables_length ms-0 ms-xl-0 flex-shrink-0 mt-4 mt-xl-0">
                                                <label class="d-inline-block me-2">Show</label>
                                                <div class="select-wrapper d-inline-block w-auto">
                                                    <select v-model="medEntries" class="form-control d-inline-block">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-xl-3 col-xxl-4 mb-0 mb-lg-0 d-block d-md-flex justify-content-end">
                                            <div class="filter-wrap d-md-flex d-block flex-column align-items-end">
                                                <div class="select-wrapper d-block w-auto">
                                                    <select v-model="med_type" name="" class="form-control" id="">
                                                        <option value="">Medicine Type</option>
                                                        <option value="tablet">Tablet</option>
                                                        <option value="capsule">Capsule</option>
                                                        <option value="syrup">Syrup</option>
                                                        <option value="drops">Drops</option>
                                                        <option value="inhaler">Inhaler</option>
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
                                                <th class="sorting">S. No.</th>
                                                <th class="sorting">Medicine Name</th>
                                                <th class="sorting">Colorsss</th>
                                                <th class="sorting">Potency/Volume</th>
                                                <th class="sorting">Medicine Type</th>
                                                <th class="sorting">Created by</th>
                                                <th class="sorting">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(user,index) in medicine_list.data" :key="index">     
                                                <td>{{++index}}</td>
                                                <td>{{user.medicine_name}}</td>
                                                <td> <input type="color" :value="user.medicine_color" disabled></td>
                                                <td>{{user.potency_volume_medicine}}</td>
                                                <td>{{user.medicine_type}}</td>
                                                <td>{{user.created_by}}</td>
                                                <td>
                                                    <div class="btn-group ml-1">
                                                        <button type="button" class="btn dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                        <router-link :to="{ name : 'admin.users.showMedicine',params : {id : user.id} }" class="dropdown-item"><i class="fa fa-eye"></i>View</router-link>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                                <no-record tag="tr" :colspan="6" :data="medicine_list.data" class="col-md-3"></no-record>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-xxl-5 align-self-center text-center text-xxl-start">
                                        <div class="dataTables_info pl-2">  Showing {{medicine_list.from}} to {{medicine_list.to}} of {{medicine_list.total}} entries</div>
                                        
                                    </div>
                                    <div class="col-sm-12 col-xxl-7 d-flex justify-content-center justify-content-xxl-end">
                                        <div class="dataTables_paginate">
                                            <ul class="pagination">
                                            <pagination :data="medicine_list" @pagination-change-page="fetch"></pagination>

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-appointment" role="tabpanel" aria-labelledby="pills-appointment-tab">
                            <div class="dataTables_wrapper pl-0 pr-0">
                                <div class="user-listing-top">
                                    <div class="row mb-2 justify-content-end">
                                        <div class="col-12 col-md-8 col-lg-8 col-xl-6 col-xxl-4 mt-3 mt-lg-0">
                                            <div class="dataTables_filter d-flex justify-content-start flex-shrink-1">
                                                <label for="" class="d-none d-md-inline-block me-2 me-lg-3 my-0 align-self-center flex-shrink-0 fw-light">Search</label>
                                                <div class="search-wrap flex-grow-1">
                                                    <input v-model="appointmentSearch" type="search" class="form-control" placeholder="Search">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-end d-flex mb-3">
                                        <div class="col-12 col-md-8 col-xl-9 col-xxl-8 mt-md-0 d-lg-flex d-block align-items-end sort-datepicker flex-wrap flex-xl-nowrap">
                                            <label class="me-3 flex-shrink-0 pb-2 pb-md-0">Sort by:</label>
                                            <div class="d-sm-flex d-block">
                                                <div class="input-wrap me-0 me-sm-3 mb-2 mb-sm-0">
                                                    <label for="">From</label>
                                                    <input v-model="appStartDate" type="date" placeholder="From" class="form-control">
                                                </div>
                                                <div class="input-wrap">
                                                    <label for="">To</label>
                                                    <input v-model="appEndDate" type="date" placeholder="To" class="form-control">
                                                </div>
                                            </div>
                                            <div class="dataTables_length ms-0 ms-xl-4 flex-shrink-0 mt-4 mt-xl-0">
                                                <label class="d-inline-block me-2 ">Show</label>
                                                <div class="select-wrapper d-inline-block w-auto">
                                                    <select v-model="appEntries" class="form-control d-inline-block">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-xl-3 col-xxl-4 mb-0 mb-lg-0 d-block d-md-flex justify-content-end">
                                            <div class="filter-wrap d-md-flex d-block flex-column align-items-end">
                                                <div class="select-wrapper d-block w-auto me-0 mb-3 mb-md-3">
                                                    <select v-model="appStatus" class="form-control" id="">
                                                        <option value="">Choose Status</option>
                                                        <option value="1">Upcoming</option>
                                                        <option value="0">Canceled</option>
                                                        <option value="2">Completed</option>
                                                        <option value="3">Pending</option>
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
                                                <th class="sorting ps-3">S. No.</th>
                                                <th class="sorting">Day to visit</th>
                                                <th class="sorting">Title</th>
                                                <th class="sorting">Doctor's Name</th>
                                                <th class="sorting">Category</th>
                                                <th class="sorting">Clinic/Hospital Name</th>
                                                <th class="sorting">Contact Number</th>
                                                <th class="sorting">Email</th>
                                                <th class="sorting">Status</th>
                                                <th class="sorting">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(appointment,index) in appointment_list.data" :key="index">
                                                <td class="">{{++index}}</td>
                                                <td>{{appointment.days_to_visit | newFormatDate}}</td>
                                                <td>{{appointment.appointment_title}}</td>
                                                <td>{{appointment.doctor_name}}</td>
                                                <td>{{appointment.category}}</td>
                                                <td>{{appointment.hospital_name}}</td>
                                                <td>{{appointment.contact_number}}</td>
                                                <td>{{appointment.email}}</td>
                                                <td>{{appointment.status == 1 ? 'Upcoming' : ''}}</td>
                                                <td>
                                                    <div class="btn-group ms-3">
                                                        <button type="button" class="btn dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                        <router-link class="dropdown-item" :to="{name : 'admin.users.appointmentDetails',params : {id : appointment.id} }"><i class="fa fa-eye"></i>VIEW</router-link>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                       <no-record tag="tr" :colspan="10" :data="appointment_list.data" class="col-md-3">
                                       </no-record>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-xxl-5 align-self-center text-center text-xxl-start">
                                        <div class="dataTables_info pl-2">  Showing {{appointment_list.from }} to {{appointment_list.to}} of {{appointment_list.total}} entries</div>

                                    </div>
                                    <div class="col-sm-12 col-xxl-7 d-flex justify-content-center justify-content-xxl-end">
                                        <div class="dataTables_paginate">
                                            <ul class="pagination">
                                           <pagination :data="appointment_list" @pagination-change-page="fetch"></pagination>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
import { mapState ,mapActions} from 'vuex';
export default {
    props: {
        detail : {
            type : Object,
            default : ()=> ({}), 
        },
    },
    data : ()=> ({
        popupMsg: '',
        updatingStatus: "",
        confirmation_popupMsg: "",
        avatar_url:null,
        medicine_list:'',
        med_type:'',
        medSearch:'',
        medEntries:'5',
        appointment_list:{},
        appointmentSearch:'',
        appStartDate:'',
        appEndDate:'',
        appEntries:'5',
        appStatus:''


    }),
      created() {
        let { page } = this.$route.query;
        this.fetch(page);
        this.fetchAppointments(page);
    },
    watch: {
        med_type: function(val, oldVal) {
            this.fetch();
        },
        medEntries: function(val, oldVal) {
            this.fetch();
        },
        medSearch: function(val, oldVal) {
            this.fetch();
        },
        appointmentSearch: function(val, oldVal) {
            this.fetchAppointments();
        },
        appStartDate: function(val, oldVal) {
            this.fetchAppointments();
        },

        appEndDate: function(val, oldVal) {
            this.fetchAppointments();
        },
        appEntries: function(val, oldVal) {
            this.fetchAppointments();
        },
        appStatus: function(val, oldVal) {
            this.fetchAppointments();
        },
    },
    methods: {
        ...mapActions('admin',['get','getAll','manageStatusUser']),
         async fetch(page = 1) {
            let { user} = this.$route.params;
            let params = {
                route: route('admin.users.usermedcine',{ user }),

                data: {
                    page,
                    med_type:this.med_type,
                    medEntries:this.medEntries,
                    medSearch:this.medSearch
                }
            };
            let { data } = await this.getAll(params);
           
            this.medicine_list = data.medicine_list;
            //  console.log( this.medicine_list)
            /* if (page != 1) {
                this.addRouteQuery({ page });
            } else {

                this.addRouteQuery({});
            } */
        },

        async fetchAppointments(page = 1) {
            let { user} = this.$route.params;
            let params = {
                route: route('admin.users.userAppointments',{ user }),

                data: {
                    page,
                    appStatus:this.appStatus,
                    appEntries:this.appEntries,
                    appEndDate:this.appEndDate,
                    appStartDate:this.appStartDate,
                    appointmentSearch:this.appointmentSearch
                }
            };
            let { data } = await this.getAll(params);
           
            this.appointment_list = data.appointment_list;
             console.log(data)
            /* if (page != 1) {
                this.addRouteQuery({ page });
            } else {

                this.addRouteQuery({});
            } */
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
            let { data } = await this.manageStatusUser({userId: users.id, status: this.updatingStatus});
            if(data.status){
                this.fetch();
                var index = await _.findIndex(this.detail, function(o) { return o.id == detail.id; });
                this.detail.status = data.data.status;
                if(data.data.status == 0){
                    this.detail.status_detail = 'Inactive';
                }else{
                     this.detail.status_detail = 'Active';
                }
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

