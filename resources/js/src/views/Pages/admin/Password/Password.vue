<template>

	<div class="container">
		<div class="row">
			<div class="col-12 col-xl-10 mx-auto">
				<div class="login-card bg-img p-0">
					<div class="row justify-content-end">
						<div class="col-12 col-lg-6 d-flex align-items-stretch">
							<div class="left d-flex align-items-center justify-content-center position-relative">
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="right px-5">
								<div class="logo text-center"><img src="images/logo.png" alt="" /></div>
								<h1 class="mb-3 mt-4">Reset your password</h1>
								<validation-observer v-slot="{handleSubmit}" >
                                 <form  @submit.prevent="handleSubmit(submit)">
									<div class="form-group">
										<label for="">New Password<span class="text-black">*</span></label>

                                        <validation-provider vid="password" tag="div" name="password" rules="required|confirmed:password_confirmation" v-slot="{errors}" class="position-relative">
                                            <input v-model="password" type="password" class="form-control new-pass-input" ref="password" id="password" placeholder="Enter New Password">
                                            <button class="btn view-btn position-absolute show-new-pass">
                                            <i class="fa fa-eye-slash enter-icon right-icon" @click="togglePasswordType('password')"  aria-hidden="true"></i>
                                            </button>
                                            <span class="text-red">{{errors[0]}}</span>
                                        </validation-provider>
									</div>

									<div class="form-group">
										<label for="">Confirm Password<span class="text-black">*</span></label>
								
                                        <validation-provider  vid="password_confirmation" tag="div" name="password confirmation" rules="required" v-slot="{errors}" class="position-relative" >
                                        <input type="password" v-model="confirm_password"  class="form-control confirm-pass-input" ref="confirm_password" id="confirmPassword" placeholder="Confirm Password">
                                        <button class="btn view-btn position-absolute show-confirm-pass">
                                        <i class="fa fa-eye-slash enter-icon right-icon" @click="togglePasswordType('confirm_password')"  aria-hidden="true"></i>
                                        </button>
                                        <span class="text-red">{{errors[0]}}</span>
                                        </validation-provider>
									</div>
									<div class="form-group text-center mt-3">
                                        <input type="submit" value="Update" class="btn btn-primary" data-toggle="modal" data-target="#passwordReset">
										<!-- <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".reset-password">Update</button> -->
									</div>
									<div class="form-group text-center bck-btn mb-0 mt-2">
										<router-link :to="{name:'admin.auth.login'}">Back to Login</router-link>
									</div>

								</form>
                                </validation-observer>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
    data() {
        return {
            password: '',
            confirm_password: '',
            errorMessage: '',
            message: '',
            tokenErrorMsg: '',
        };
    },
    async beforeCreate() {
        try {
        	let email = localStorage.getItem('email');
        	let code = localStorage.getItem('code');
            let res = await axios.post(route('password.token',{token : code }), { email });
        } catch (e) {
        	if(e.response){

            this.tokenErrorMsg = e.response.data.msg;
        	}
        }
    },
    methods: {
        changeVerificationType() {
            if (this.verifyType == 'email') {
                this.verifyType = 'phone';
            } else {

                this.verifyType = 'email';
            }
        },
        async submit(e) {
            let fd = new FormData(this.$refs.newPassword);
            fd.append('code', localStorage.getItem('code'));
            fd.append('email', localStorage.getItem('email'));
            fd.append('password', this.password);
            fd.append('confirm_password',this.confirm_password);
            let response = await axios.post(route('admin.password.update'), fd);
            if (response.data.status) {
                localStorage.removeItem('code');
                localStorage.removeItem('email');
                var self = this;
                this.$router.replace({ name: 'admin.auth.login' });
                this.$snotify.success(response.data.msg, 'Updated!');

            } else {
                this.$snotify.error(response.data.msg, 'Oops!');
            }
        }
    }
}

</script>
