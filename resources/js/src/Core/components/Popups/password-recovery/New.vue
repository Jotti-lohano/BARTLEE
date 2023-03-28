<template>
    <ValidationObserver class="modal-content" tag="div" ref="codeObserver" v-slot="{handleSubmit}">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="right">
                <h6>Password Recovery</h6>
                <form ref="newPassword" @submit.prevent="handleSubmit(onSubmit)">
                    <div class="row">
                        <ValidationProvider tag="div" rules="required|confirmed:password_confirmation" v-slot="{errors}" name="Password" class="col-12 form-group">
                            <input v-model="password" type="password" placeholder="Enter New Password" class="form-control">
                            <i class="fas fa-lock"></i>
                            <button type="button" class="view-btn position-absolute"><i class="fa fa-eye-slash"></i> </button>
                            <div class="text-danger">{{errors[0]}}</div>
                        </ValidationProvider>
                        <ValidationProvider tag="div" rules="required" vid="password_confirmation" v-slot="{errors}" name="Password confirmation" class="col-12 form-group">
                            <input v-model="password_confirmation" type="password" placeholder="Retype Password" class="form-control">
                            <i class="fas fa-lock"></i>
                            <button type="button" class="view-btn position-absolute"><i class="fa fa-eye-slash"></i> </button>
                            <div class="text-danger">{{errors[0]}}</div>
                        </ValidationProvider>
                    </div>
                    <!-- <button type="button" onclick="parent.location=''"
                                    class="can m-0"> Continue</button> -->
                    <button type="submit" class="can m-0">
                        UPDATE</button>
                    <a href="javascript:void(0)" data-dismiss="modal" class="login back"><i class="fa fa-arrow-circle-left"></i>back to
                        login</a>
                </form>
            </div>
        </div>
        <!-- 
        <form ref="newPassword" @submit.prevent="handleSubmit(onSubmit)">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h2 class="site-modalheading">Password Recovery</h2>
            <ValidationProvider tag="div" rules="required|confirmed:password_confirmation" v-slot="{errors}" name="Password" class="form-field">
                <i class="fa fa-lock left-icon" aria-hidden="true"></i>
                <input v-model="password" type="password" class="site-input login both-icon confirm-input" placeholder="Enter New Password" name="" id="">
                <i class="fa fa-eye-slash confirm-icon right-icon" aria-hidden="true"></i>
                <div class="text-danger">{{errors[0]}}</div>
            </ValidationProvider>
            <ValidationProvider tag="div" rules="required" vid="password_confirmation" v-slot="{errors}" name="Password confirmation" class="form-field">
                <i class="fa fa-lock left-icon" aria-hidden="true"></i>
                <input v-model="password_confirmation" type="password" class="site-input login both-icon enter-input" placeholder="Retype Password" name="" id="">
                <i class="fa fa-eye-slash enter-icon right-icon" aria-hidden="true"></i>
                <div class="text-danger">{{errors[0]}}</div>
            </ValidationProvider>
            <button type="submit" class="login-btn mb-4">confirm</button>
            <div class="text-center">
                <a  href="javascript:void(0)" @click="openLoginPopup"  class="back-link d-inline-block mt-3" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left mr-1" aria-hidden="true"></i>Back to Login</a>
            </div>
        </form>
     -->
    </ValidationObserver>
</template>
<script>
export default {
    props: {
        email: {
            type: String, // String, Number, Boolean, Function, Object, Array
            required: true,
            default: null
        },
        code: {
            type: String, // String, Number, Boolean, Function, Object, Array
            required: true,
            default: null
        }
    },
    data() {
        return {
            password: '',
            password_confirmation: '',
        };
    },
    methods: {
        openLoginPopup() {
            // $('.auth-popup').modal('show');
            // bus.$emit('show-login', 'Login');
        },
        async onSubmit(e) {
            let fd = new FormData();
            this.buildFormData(fd, this.$data);
            fd.append('code', this.code);
            let response = await axios.post(route('admin.password.update'), fd);
            if (response.data.status) {
                var self = this;
                this.$snotify.success(response.data.msg, 'Updated!');
                this.$emit('change-forget-preview', { component: 'Email', email: '', code: '' });
                $('#pwdrecovery').modal('hide')
                // this.openLoginPopup();

            } else {
                this.$snotify.error(response.data.msg, 'Oops!');
            }
        }
    }
}

</script>
