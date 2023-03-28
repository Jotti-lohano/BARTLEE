<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="configuration" class="user-page">
                <div class="page-title mb-4">
                    <div class="row">
                        <div class="col-12">
                            <h2><a @click="$router.go(-1)"><i class="fa fa-chevron-left"></i></a>Appointment Details</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-10 shadow-none">
                            <div class="card-body p-4 p-lg-5">
                                <div class="page-title">
                                    <div class="row mb-3 mb-lg-0">
                                        <div class="col-12 col-lg-8 align-self-center">
                                            <h3 class="fw-medium mb-3 mb-lg-5">{{appointment_details.appointment_title}}</h3>
                                        </div>
                                        <div class="col-lg-4 text-start text-lg-end">
                                            <span class="status upcoming text-white fs-16">{{appointment_details.status == 1 ? 'Upcoming' : 'Pending'}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-block mb-0 pb-0 appointment-detail-block">
                                    <div class="row">
                                        <div class="col-12 col-xl-12">
                                            <div class="media d-md-flex d-block">
                                                <div class="media-body flex-grow-1 ps-0 mb-3">
                                                    <div class="row mb-3 mb-lg-4 mb-xxl-5">
                                                        <div class="col-12">
                                                            <h3 class="text-seegreen">{{appointment_details.doctor_name}}</h3>
                                                            <p>{{appointment_details.category}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 mb-lg-4 mb-xxl-5">
                                                        <div class="col-12">
                                                            <label for="">Clinic/Hospital Name:</label>
                                                            <p>{{appointment_details.hospital_name}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 mb-lg-4 mb-xxl-5">
                                                        <div class="col-12">
                                                            <label for="">Location/Address:</label>
                                                            <p>{{appointment_details.location}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 mb-lg-4 mb-xxl-5">
                                                        <div class="col-12">
                                                            <label for="">Contact Number:</label>
                                                            <p>{{appointment_details.contact_number}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 mb-lg-4 mb-xxl-5">
                                                        <div class="col-12">
                                                            <label for="">Email:</label>
                                                            <p>{{appointment_details.email}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 mb-lg-4 mb-xxl-5">
                                                        <div class="col-12">
                                                            <label for="">Diagnosed Disease:</label>
                                                            <p>Diabetes</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 mb-lg-4 mb-xxl-5">
                                                        <div class="col-12 col-md-10 col-lg-7 col-xxl-5">
                                                            <label for="">Additional Notes:</label>
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin ravida
                                                                dolor sit amet lacus accumsan et viverra justo</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 mb-lg-4 mb-xxl-5">
                                                        <div class="col-lg-4 col-xxl-3 mb-3 mb-lg-0">
                                                            <label for="">Appointment Date</label>

                                                            <p v-for="(appointmentDate,index) in appointment_details.appointment_dates" :key="index">
                                                                <span class="d-block">{{appointmentDate.reminder_date | newFormatDate}}</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-4 col-xxl-3">
                                                            <label for="">Reminder Time</label>
                                                            <p>{{appointment_details.visit_time}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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
        avatar_url:null,
        appointment_details:'',
        med_type:'',
        medSearch:'',
        medEntries:'10',
        appointment_list:{}
    }),
     created() {
        this.fetch();
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
    },
    methods: {
        ...mapActions('admin',['get']),
         async fetch() {
            let {user} = this.$route.params;
            let params = {
                route: route('admin.users.userAppointmentsDetails',{ user:this.$route.params }),

                data: {
                    med_type:this.med_type,
                    medEntries:this.medEntries,
                    medSearch:this.medSearch
                }
            };
            let { data } = await this.get(params);
           
            this.appointment_details = data.appointment_details;
             console.log( this.appointment_details)
            /* if (page != 1) {
                this.addRouteQuery({ page });
            } else {

                this.addRouteQuery({});
            } */
        },
    
    }
}
</script>
