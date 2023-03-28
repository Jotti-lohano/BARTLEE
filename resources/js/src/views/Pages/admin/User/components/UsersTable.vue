<template>
    <div class="w-100 maain-tabble table-responsive">
        <table class="table table-striped table-bordered zero-configuration">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>NAME</th>
                    <th>DATE</th>
                    <th>EMAIL</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <template>
                    <tr :key="index" v-for="(user,index) in users.data">
                       
                        <template>
                            <td>{{serialNumber('users',index)}}</td>
                            
                            <td>{{user.name}}</td>
                            <td>{{formatDate(user.created_at)}}</td>
                            <td>{{user.email}}</td>
                            <td>
                                <div v-if="user.status == '1'" class="btn-group mr-1 mb-1">
                                    <button type="button" class="btn btn-status active-status" data-toggle="dropdown">
                                        Active
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                   
                                    <div class="dropdown-menu status-dd">
                                        <a @click="changeStatusPopUp(user, 'inactive')" class="dropdown-item inactive-status" href="javascript:void(0)" >Inactive</a>
                                    </div>
                                </div>

                                <div v-else class="btn-group mr-1 mb-1">
                                    <button type="button" class="btn btn-status not-active" data-toggle="dropdown">
                                        In-Active
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu status-dd">
                                        <a @click="changeStatusPopUp(user, 'active')" class="dropdown-item active-status" href="javascript:void(0)" >Active</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group mr-1 mb-1">
                                    <button type="button" class="btn btn-drop-table btn-sm" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu">
                                        
                                        <router-link class="dropdown-item" :to="{name : 'admin.users.show',params : {user : user.id, type : 'detail'} }"><i class="fa fa-eye"></i>VIEW</router-link>


                                        <router-link class="dropdown-item" :to="{name : 'admin.users.show',params : {user : user.id, type : 'edit'} }"><i class="fa fa-edit"></i>EDIT</router-link>

                                        <a class="dropdown-item" href="user-paylog.php"><i class="fas fa-money-bill"></i>
                                            Paylog</a>

                                    </div>
                                </div>
                            </td>
                        </template>
                    </tr>
                </template>
                <no-record tag="tr" :colspan="6" :data="users.data" class="col-md-3"></no-record>
            </tbody>
        </table>
       
        <div class="modal fade modal-schp" id="activate-user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19.818" height="19.819" viewBox="0 0 19.818 19.819">
                            <path id="Icon_metro-cross" data-name="Icon metro-cross" d="M22.209,17.85h0L16.2,11.837l6.012-6.012h0a.621.621,0,0,0,0-.876l-2.84-2.84a.621.621,0,0,0-.876,0h0L12.48,8.121,6.468,2.109h0a.621.621,0,0,0-.876,0l-2.84,2.84a.621.621,0,0,0,0,.876h0l6.012,6.012L2.752,17.85h0a.621.621,0,0,0,0,.876l2.84,2.84a.621.621,0,0,0,.876,0h0l6.012-6.012,6.012,6.012h0a.621.621,0,0,0,.876,0l2.84-2.84a.621.621,0,0,0,0-.876Z" transform="translate(-2.571 -1.928)" fill="red" />
                        </svg>
                    </button>
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="images/modal-question.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-12 text-center mt-2">
                            <p class="modal-paragraph">{{ popupMsg }}</p>
                        </div>
                        <div class="col-12 text-center mt-1 d-flex justify-content-center align-items-center flex-sm-row flex-column">
                            <a href="#" class="outling-purple mr-sm-2 mb-2 mb-sm-0" data-dismiss="modal">No</a>
                            <a href="#" class="purple-solid" data-dismiss="modal" @click="changeStatus()">Yes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-schp" id="activated-user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19.818" height="19.819" viewBox="0 0 19.818 19.819">
                            <path id="Icon_metro-cross" data-name="Icon metro-cross" d="M22.209,17.85h0L16.2,11.837l6.012-6.012h0a.621.621,0,0,0,0-.876l-2.84-2.84a.621.621,0,0,0-.876,0h0L12.48,8.121,6.468,2.109h0a.621.621,0,0,0-.876,0l-2.84,2.84a.621.621,0,0,0,0,.876h0l6.012,6.012L2.752,17.85h0a.621.621,0,0,0,0,.876l2.84,2.84a.621.621,0,0,0,.876,0h0l6.012-6.012,6.012,6.012h0a.621.621,0,0,0,.876,0l2.84-2.84a.621.621,0,0,0,0-.876Z" transform="translate(-2.571 -1.928)" fill="red" />
                        </svg>
                    </button>
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="images/check.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-12 text-center mt-2">
                            <p class="modal-paragraph">{{ confirmation_popupMsg }}</p>
                        </div>
                        <div class="col-12 text-center mt-1 d-flex justify-content-center align-items-center flex-sm-row flex-column">
                            <a href="#" class="purple-solid" data-dismiss="modal">Ok</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
const Confirm = () => import('@core/components/Popups/Confirm.vue');
import { mapState, mapActions } from 'vuex';
export default {
    components: {
        Confirm
    },
    computed: {
        ...mapState('admin', ['users']),
        status() {
            return this.$route.params.status;
        }
    },
    data () {
      return {
        editUser: {},
        popupMsg: '',
        updatingStatus: "",
        confirmation_popupMsg: ""
      };
    },
    methods: {
        ...mapActions('admin', ['manageStatus']),
        changeStatusPopUp(user, status){
            $('#activate-user-modal').modal('show');

            if(status == 'inactive'){
                this.popupMsg = 'Are you sure you want to mark this user as in-active?';
                this.updatingStatus = "0";
            }else{
                this.popupMsg = 'Are you sure you want to mark this user as active?';
                this.updatingStatus = "1";
            }
            this.editUser = {};
            this.editUser = user;
        },
        async changeStatus(){

            let user = this.editUser;
            let { data } = await this.manageStatus({userId: user.id, statusToChange: this.updatingStatus});
            if(data.status){
                var index = await _.findIndex(this.users.data, function(o) { return o.id == user.id; });
                this.users.data[index]['status'] = data.user.status;
            }
            if(this.updatingStatus == "1"){
                this.confirmation_popupMsg = 'User activated successfully!';
            }else{
                this.confirmation_popupMsg = 'User In-activated successfully!';
            }
            $('#activated-user-modal').modal('show');
            setTimeout(()=>{
                $('#activated-user-modal').modal('hide');
            }, 3000);
        }
    }
}

</script>
