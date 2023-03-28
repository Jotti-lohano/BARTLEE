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
								<h1 class="mb-5 mt-5">Did you forget your password?</h1>
								      <validation-observer v-slot="{handleSubmit}" class="col-12">
                                    <form ref='verify' @submit.prevent="handleSubmit(submit)">
			
                                     <validation-provider tag="div" rules="required|email" v-slot="{errors}" class="form-group">
                                         <label for="">Email Address<span class="text-black">*</span></label>
                                        <input type="email" v-model="email" name="Email" placeholder="Enter Email Address" class="form-control">
                                        <span class="text-red">{{errors[0]}}</span>
                                    </validation-provider>

									<div class="form-group text-center mt-2 mt-lg-3">
										<button type="submit" class="btn btn-primary px-4">Request Reset link</button>
									</div>
									<div class="form-group text-center bck-btn mb-0 mt-2 mt-lg-2">
										<!-- <a href="login.php">Back To Login</a> -->
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
               email: '',
        };
    },
    methods: {
        async submit(e) {
            try {
                let response = await axios.post(route('admin.password.verify'), {email : this.email});
                let self = this;
                if (response.data.status) {
                    localStorage.setItem('email', this.email);
                    this.$router.push({ name: 'admin.pr.code' });
                    this.$snotify.success(response.data.message);
                } else {
                    this.$snotify.error(response.data.message);
                }
            } catch (e) {
                    if(e.response){
                        this.$snotify.error(e.response.data.errors.email[0]);
                        this.$refs.verify.setErrors(e.response?.data?.errors);
                }
            }
        }
    }
}

</script>
