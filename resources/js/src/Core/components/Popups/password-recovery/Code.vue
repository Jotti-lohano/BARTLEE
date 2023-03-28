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
                <form ref="validateCode" @submit.prevent="handleSubmit(onSubmit)">
                    <div class="row">
                        <ValidationProvider tag="div" vid="code" name="code" rules="required" v-slot="{errors}" class="col-12 form-group">
                            <strong>Enter Security Code</strong>
                            <label for="exampleInputEmail1" class="form-label"><small> Please check your
                                    email for
                                    code. Your code is 6 characters in length.</small></label>
                            <input v-model="code" type="text" class="form-control" placeholder="Enter Code">
                            <i class="fas fa-check-circle"></i>
                            <div class="text-danger">{{errors[0]}}</div>
                            <a href="javascript:void(0)" @click="onResend" class="green-small"><small>Didn't get a code?</small></a>
                        </ValidationProvider>
                    </div>
                    <button type="submit" class="can m-0" id="pwd1-btn">Continue</button>
                    <!-- <a href="javascript:void(0)" class="can m-0" data-dismiss="modal" data-toggle="modal" data-target="#new-password"> Continue</a> -->
                    <a href="javascript:void(0)" data-dismiss="modal" class="login back"><i class="fa fa-arrow-circle-left"></i>back to
                        login</a>
                </form>
            </div>
            <!-- 
            <form ref="validateCode" @submit.prevent="handleSubmit(onSubmit)">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="site-modalheading">Password Recovery</h2>
                <ValidationProvider tag="div" vid="code" name="code" rules="required" class="form-field" v-slot="{errors}">
                    <i class="fa fa-pen left-icon" aria-hidden="true"></i>
                    <input v-model="code" type="text" class="site-input login left-icon" placeholder="Enter Verification Code" name="" id="">
                    <div>{{errors[0]}}</div>
                </ValidationProvider>
                <a href="javascript:void(0)" @click="onResend" class="forgot-link d-block text-right mb-1">Re-send Code</a>
                <button type="submit" class="login-btn mt-2 mb-4" id="pwd1-btn">Continue</button>
                <div class="text-center">
                    <a href="javascript:void(0)" @click="openLoginPopup" class="back-link d-inline-block mt-3" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left mr-1" aria-hidden="true"></i>Back to Login</a>
                </div>
            </form>
         -->
        </div>
    </ValidationObserver>
</template>
<script>
export default {
    props: {
        email: {
            type: String, // String, Number, Boolean, Function, Object, Array
            required: true,
            default: null
        }
    },
    data() {
        return {
            isSending: false,
            code: '',
        };
    },
    methods: {
        openLoginPopup() {
            $('.auth-popup').modal('show');
            bus.$emit('show-login', 'Login');
        },
        async onResend(e) {
            let fd = new FormData();
            fd.append('email', this.email);
            if (!this.isSending) {
                this.isSending = true;
                let response = await axios.post(route('admin.password.verify'), fd);
                if (response.data.status) {
                    let self = this;
                    this.isSending = false;
                    setTimeout(function() {
                        self.$snotify.success(response.data.msg);
                    }, 1000);
                } else {
                    this.$snotify.error(response.data.msg);
                }
            } else {

                this.$snotify.error('already sending', 'Please Wait!');
            }
        },
        async onSubmit(e) {
            let fd = new FormData(this.$refs.validateCode);
            fd.append('email', this.email);
            fd.append('code', this.code);
            try {
                let response = await axios.post(route('admin.password.token',{token : this.code}), fd);
                if (response.data.status) {
                    this.$snotify.success(response.data.msg);
                    this.$emit('change-forget-preview', { component: 'New', email: this.email, code: this.code });
                } else {
                    this.$snotify.error(response.data.msg, 'Invalid Code');
                }
            } catch (e) {
                if (e.response) {
                    this.$refs.codeObserver.setErrors(e.response.data.errors);
                }
                console.log(e);
            }
        }
    }
}

</script>
