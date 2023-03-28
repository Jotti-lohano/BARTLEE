<template>
    <section id="configuration" class="">
        <div class="row p-4">
            <div class="col-12">
                <router-link :to="{name : 'admin.users.index'}">
                    <h3 class="fc-purple"><i class="fas fa-chevron-left"></i> EDIT PROFILE</h3>
                </router-link>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-center">
                
            </div>
        </div>

        <div class="row headingBar my-2">
            <div class="col-lg-12 mb-2">
                <h4 class="fc-purple">Account</h4>
            </div>
        </div>

        <ValidationObserver ref="reasonObserver" v-slot="{handleSubmit}">
            <form @submit.prevent="handleSubmit(updateProfile)">
                <div class="row">
                    <div class="col-lg-6">
                        <ValidationProvider tag="div" name="name" rules="required" v-slot="{errors}" class="form-group">
                            <div class="form-group">
                                <label for="updatename">Name</label>
                                <input id="updatename" type="" class="form-control" name="name" v-model="user.name">
                            </div>
                            <div class="text-danger">{{errors[0]}}</div>
                        </ValidationProvider>
                    </div>

                    <div class="col-lg-6">
                        <ValidationProvider tag="div" name="email" rules="" v-slot="{errors}" class="form-group">
                            <div class="form-group">
                                <label for="">Email</label>
                                <p>{{ user.email }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                
                </div>

                <div class="row headingBar my-2">
                    <div class="col-lg-12 mb-2">
                        <h4 class="fc-purple">Password</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                       
                         <ValidationProvider tag="div" name="current password" rules="" v-slot="{errors}" class="form-group">
                            <div class="form-group position-relative">
                                <label for="current-password">Current Password</label>
                                <input id="current-password" type="password" class="form-control" name="current password" v-model="current_password">
                                <button type="button" class="btn-eye"><i class="fas fa-eye-slash"></i></button>
                            </div>
                            <div class="text-danger">{{errors[0]}}</div>
                            <div v-if="showErrorCurrentPassword" class="text-danger">invalid current password</div>
                        </ValidationProvider>
                    </div>
                    <div class="col-lg-6">
                        <ValidationProvider tag="div" name="new password" :rules="`${isRequired ? 'required' : ''}|min:6|confirmed:confirm password`" v-slot="{errors}" class="form-group">
                            <div class="form-group position-relative">
                                <label for="new-password">New Password</label>
                                <input id="new-password" type="password" class="form-control" name="new password" v-model="new_password">
                                <button type="button" class="btn-eye"><i class="fas fa-eye-slash"></i></button>
                            </div>
                            <div class="text-danger">{{errors[0]}}</div>
                        </ValidationProvider>
                    </div>
                    <div class="col-lg-6">
                        <ValidationProvider tag="div" name="confirm password" 
                            :rules="`${isRequired ? 'required' : ''}|min:6`"
                            v-slot="{errors}" class="form-group">
                            <div class="form-group position-relative">
                                <label for="confirm-password">Confirm Password</label>
                                <input id="confirm-password" type="password" class="form-control" name="confirm password" vid="confirm password" v-model="confirm_password">
                                <button type="button" class="btn-eye"><i class="fas fa-eye-slash"></i></button>
                            </div>
                            <div class="text-danger">{{errors[0]}}</div>
                        </ValidationProvider>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center my-4">
                        <button type="submit" class="btn-purple can2">UPDATE</button>
                    </div>
                </div>
            </form>
        </ValidationObserver>


        <!-- <div class="row headingBar my-2">
            <div class="col-lg-12 mb-2">
                <h4 class="fc-purple">Password</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group position-relative">
                    <label for="">Current Password</label>
                    <input type="password" class="form-control" name="" value="Mark Carson">
                    <button type="button" class="btn-eye"><i class="fas fa-eye-slash"></i></button>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group position-relative">
                    <label for="">New Password</label>
                    <input type="password" class="form-control" name="" value="Mark Carson">
                    <button type="button" class="btn-eye"><i class="fas fa-eye-slash"></i></button>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group position-relative">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control" name="" value="Mark Carson">
                    <button type="button" class="btn-eye"><i class="fas fa-eye-slash"></i></button>
                </div>
            </div>
        </div> -->

       <!--  <div class="row">
            <div class="col-lg-12 text-center my-4">
                <a href="javascript:void(0)" @click="updateProfile(user.id, user.name)" class="btn-purple">Update</a>
            </div>
        </div> -->

    </section>
</template>
<script>
import { mapState ,mapActions} from 'vuex';
export default {
    computed: {
        ...mapState('admin', ['user','search']),
    },
    data() {
        return {
            isRequired: false,
            current_password: '',
            new_password: '',
            confirm_password: '',
            showErrorCurrentPassword: false
        }
    },
    watch: {
      current_password: function(val, oldVal) {
        if(val.length > 0){
            this.isRequired = true;
        }else{
            this.isRequired = false;
            this.new_password = '';
            this.confirm_password = '';
        }
      }
    },
    methods: {
    	...mapActions('admin',['store']),
        async updateProfile() {
            let fd = new FormData();
            fd.append('name',this.user.name);
            fd.append('id',this.user.id);
            if(this.isRequired){
                fd.append('current_password',this.current_password);
                fd.append('new_password',this.new_password);
                fd.append('confirm_password',this.confirm_password);
            }

            let {data} = await  axios.post('admin/user/user-update', fd);
            if(data.status){
                this.$snotify.success(data.msg);
                this.user.name = data.user.name;
                this.current_password = '';
                this.showErrorCurrentPassword = false;
            }else{
                if(data.msg == 'Invalid Current Password!'){
                    this.showErrorCurrentPassword = true;
                }
                this.$snotify.error(data.msg);
            }
        
        },
    }
}
</script>
