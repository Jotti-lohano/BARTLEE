<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <!-- Basic form layout section start -->
        <section id="inquiry_detail" class="inquiry-detail">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12">
                        <h2><a @click="$router.go(-1)"><i class="fa fa-chevron-left"></i></a>Inquiry Details</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="content-body bg-white rounded-10 shadow-none p-4 p-lg-5">
                        <div class="row">
                            <div class="col-12 col-xl-10">
                                <div class="detail-block media d-md-flex d-block">
                                    <div class="media-body flex-grow-1 ps-0">
                                        <div class="row mb-3 mb-lg-5">
                                            <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                                <label for="">First Name</label>
                                            </div>
                                            <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                                <p>{{faq.firstname}}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3 mb-lg-5">
                                            <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                                <label for="">Last Name</label>
                                            </div>
                                            <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                                <p>{{faq.lastname}}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3 mb-lg-5">
                                            <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                                <label for="">Customer Email:</label>
                                            </div>
                                            <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                                <p>{{faq.email}}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3 mb-lg-5">
                                            <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                                <label for="">Contact Number:</label>
                                            </div>
                                            <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                                <p>{{faq.phone_no}}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3 mb-lg-5">
                                            <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                                <label for="">Subject:</label>
                                            </div>
                                            <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                                <p>{{faq.subject}}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3 mb-lg-5">
                                            <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                                <label for="">Message: </label>
                                            </div>
                                            <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                                <p>{{faq.message}}</p>
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
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    components: {
    },
    data() {
        return {
            faq : {},
            form:{
                medicine_type:'',
                volume: '',
            }, 
            type : '',
            entries : 10,
            search : null,
            popupMsg: '',
            updatingStatus: "",
            confirmation_popupMsg: "",
            active_id : this.$route.params.id,
            edit_data:[]
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
        ...mapActions('admin', ['get']),
        async fetch(page = 1) {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.faqs.show',this.$route.params),
                data: {
                    page,
                    type,
                    status: this.currentStatus,
                    search : this.search,
                    entries : this.entries,
                    type : this.type,
                }
            };

            let { data } = await this.get(params);
            console.log(data);
            this.faq = data.faqs;
           
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