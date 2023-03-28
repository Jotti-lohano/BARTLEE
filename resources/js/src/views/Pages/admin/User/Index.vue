<template>
<div class="app-content content">
    <div class="content-wrapper">
        <section id="user_page" class="user-page">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12">
                        <h2>Users</h2>
                    </div>
                </div>
            </div>
            <div class="content-body bg-white rounded-10 shadow-sm p-4 p-lg-5">
                <div class="dataTables_wrapper">
                    <div class="user-listing-top">

                        <div class="row">
                        </div>
                    </div>
                    <div class="main-tabble table-responsive mx-n2">
                         <Table @page-changed="fetch" :fields="tableFields" :data="users">
                            <table-search
                                show-status

                                @on-search="setCallback('search',$event,fetch)"
                                @on-change-entries="setCallback('entries',$event,fetch)"
                                @on-change-status="setCallback('currentStatus',$event,fetch)"
                                @on-change-userType="setCallback('userType',$event,fetch)"
                                @on-change-userSubscription="setCallback('userSubscription',$event,fetch)"
                            />
                            <template #extra-heads>
                                <th>Action</th>
                            </template>
                            <template #extra-cells="item">
                                <td>
                                        <div class="btn-group ml-1">
                                            <button type="button" class="btn dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <router-link  v-if="item.user_type == 'attendee'" :to="{ name : 'admin.users.show',params : {user : item.id, type : 'attendee'} }" class="dropdown-item mb-1"><i class="bi bi-eye table-eye pr-2 "></i>View</router-link>
                                                <router-link v-else :to="{ name : 'admin.users.show',params : {user : item.id, type : 'patient'} }" class="dropdown-item mb-1"><i class="bi bi-eye table-eye pr-2 "></i>View</router-link>
                                                <a v-if="item.status == 0" class="dropdown-item mb-1" @click="changeStatusPopUp(item, 'active')" data-toggle="modal" data-target=""><i class="bi bi-x-circle pr-2"></i>Active</a>
                                                <a v-else class="dropdown-item mb-1" @click="changeStatusPopUp(item, 'inactive')" data-toggle="modal" data-target=""><i class="bi bi-x-circle pr-2"></i>Inactive</a>
                                            </div>
                                        </div>
                                    </td>
                            </template>
                        </Table>
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
    computed: {
        tableFields(){
                return [
                    {
                        label : 'First Name',
                        key : 'first_name',

                    },
                    {
                        label : 'Last Name',
                        key : 'last_name',

                    },
                    {
                        label : 'Email',
                        key : 'email',

                    },
                    {
                        label : 'User Type',
                        key : 'user_type',

                    },
                    {
                        label : 'Status',
                        key : 'status_detail',
                    },
                    {
                        label : 'Signup Type',
                        key : 'user_subscription_count',
                        format : (value)=> {
                            if(value > 0 ){
                                return "Subscriber"
                            }else{
                                return "Free User"
                            }

                        }
                    },

                ]
        },
    },
    components: {
    },
    data() {
        return {
            users : {},
            userType:'',
            userSubscription:'',
            currentStatus: '',
            dateFrom: '',
            dateTill: '',
            fromDateCheck: false,
            tillDateCheck: false,
            type : '',
            entries : 10,
            cards:{
                totalUser:0,
                avgUserMonthly:0,
                avgUserDay:0,
                lastTwoWeeks:0,
                avgUsers:0
            },
            duration:{
            avgUsers:'all',
             },
            search : null,
            popupMsg: '',
            updatingStatus: "",
            confirmation_popupMsg: "",
        };
    },
    created() {
        // this.type = this.$route.params.type?'business':'';
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

    },
    methods: {
        ...mapActions('admin', ['getAll','manageStatusUser']),
        async fetch(page = 1) {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.user.index'),
                mutation: 'SET_USERS',
                variable: 'users',
                data: {
                    page,
                    type,
                    status: this.currentStatus,
                    search : this.search,
                    entries : this.entries,
                    dateFrom: this.dateFrom,
                    dateTill: this.dateTill,
                    type : this.type,
                    userType:this.userType,
                    userSubscription:this.userSubscription
                }
            };
            let { data } = await this.getAll(params);
            this.users = data.users;
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
