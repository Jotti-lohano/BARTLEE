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
								<h1 class="mb-3 mt-5">Forget Password</h1>
								<p class="text-center mb-4">An email has been sent to you with a verification code. <br>
									please enter it here.</p>
								<validation-observer v-slot="{handleSubmit}" >
                                <form  @submit.prevent="handleSubmit(onSubmit)">
									<div class="form-group mb-3">
										<label for="">Verification Code<span class="text-black">*</span></label>
										
                                         <validation-provider tag="div" name rules="required" v-slot="{errors}" class="position-relative">
                                            <input type="number" v-model="code" name="Code" placeholder="Enter Verification Code" class="form-control">
                                            <span class="text-red">{{errors[0]}}</span>
                                        </validation-provider>
									</div>
									<div class="form-group">
										<div class="d-flex justify-content-between px-3">
											<div class="forgot-pass">Resending In 00:50</div>
											<div class="forgot-pass">
                                                <a href="javascript:void(0)" @click="onResend()">Resend Code</a>
											</div>
										</div>
									</div>
									<div class="form-group text-center mt-3">
										<button type="submit" class="btn btn-primary">Continue</button>
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
            isSending: false,
            code: '',
            // verifyType: 'email',
        };
    },
    created() {
        let email = localStorage.getItem('email');
        if (!email) {
            this.$snotify.error('Please Follow the first step & verify your Email Address', 'Forbidden!');
            this.$router.push({ name: 'web.password.email' });
        }
    },
    methods: {
        async onResend(e) {
            let fd = new FormData();
            fd.append('email', localStorage.getItem('email'));
            if (!this.isSending) {
                this.isSending = true;
                let response = await axios.post(route('admin.password.verify'), fd);
                if (response.data.status) {
                    let self = this;
                    this.isSending = false;
                    setTimeout(function() {
                        self.$snotify.success(response.data.message);
                    }, 1000);
                } else {
                    this.$snotify.error(response.data.message);
                }
            } else {
                this.$snotify.error('already sending', 'Please Wait!');
            }
        },
        async onSubmit(e) {
            let fd = new FormData(this.$refs.validateCode);
            fd.append('code',this.code);

            let response = await axios.post(route('admin.password.token',{token : this.code}), fd);
            if (response.data.status) {
                localStorage.setItem('code', this.code);
                var self = this;
                this.$router.push({ name: 'admin.pr.new' });
                this.$snotify.success(response.data.msg, 'Verified');

            } else {
                this.$snotify.error(response.data.msg, 'Invalid Code');
            }
        }
    }
}

</script>
