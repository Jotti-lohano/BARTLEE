<template>
<div class="app-content content ">
	<div class="content-wrapper">

		<!-- Basic form layout section start -->
		<section id="change_password" class="my-profile">
			<div class="page-title mb-4">
				<div class="row">
					<div class="col-12 col-lg-12">
						<h2>
                            <!-- <a href="profile.php"><i class="fa fa-chevron-left"></i></a>  -->
                              <router-link :to="{ name: 'admin.account.index'  }"><i class="fa fa-chevron-left"></i>  Change Password
                            </router-link>
                            
                            
                           </h2>
					</div>
				</div>
			</div>
			<div class="content-body bg-white rounded-10 shadow-sm p-4 p-lg-5">
				<div class="row">
					<div class="col-12 col-lg-7 col-xxl-5">
						    <validation-observer v-slot="{handleSubmit}">
                                <form @submit.prevent="handleSubmit(update)">
							<div class="row form-group">
								<div class="col-12">
									<label class="fw-medium ps-1 mb-2">Current Password<span class="text-black">*</span></label>
									
                       
                                <validation-provider class="position-relative" tag="div" rules="required" name="Current Password" v-slot="{errors}" >
                                    <input ref="current_password" type="password" name="Current Password" v-model="form.current_password" class="form-control enter-input1" id="password" placeholder="Current Password">
                                   <button class="btn view-btn position-absolute" onclick="event.preventDefault()">
                                    <i class="fa fa-eye-slash enter-icon1 right-icon" @click="togglePasswordType('current_password')" aria-hidden="true"></i>
                                   </button>
                                     <span class="text-danger">{{errors[0]}}</span>
                                </validation-provider>



								</div>
							</div>
							<div class="row form-group">
								<div class="col-12">
									<label class="fw-medium ps-1 mb-2">New Password<span class="text-black">*</span></label>
									
                                

                                    <validation-provider tag="div" rules="required" name="New Password" v-slot="{errors}" class="position-relative">
                                    <input ref="password" type="password" name="New Password" v-model="form.password" class="form-control enter-input2" id="password" placeholder="New Password">
                                   <button class="btn view-btn position-absolute" onclick="event.preventDefault()">
                                    <i class="fa fa-eye-slash enter-icon1 right-icon" @click="togglePasswordType('password')" aria-hidden="true"></i>
                                    </button>
                                     <span class="text-danger">{{errors[0]}}</span>
                                    </validation-provider>


								</div>
							</div>
							<div class="row form-group">
								<div class="col-12">
									<label class="fw-medium ps-1 mb-2">Confirm Password<span class="text-black">*</span></label>
									
                            

                                    <validation-provider class="position-relative" tag="div" name="Confrim Password" rules="required" vid="password_confirmation"  v-slot="{errors}" >
                                    <input ref="password_confirmation" name="Confrim Password" v-model="form.password_confirmation" type="password" class="form-control enter-input3" id="password" placeholder="Confirm Password">
                                    <button class="btn view-btn position-absolute" onclick="event.preventDefault()">
                                    <i class="fa fa-eye-slash enter-icon3 right-icon" @click="togglePasswordType('password_confirmation')" aria-hidden="true"></i>
                                    </button>
                                     <span class="text-danger">{{errors[0]}}</span>
                                    </validation-provider>


								</div>
							</div>
							<div class="row detail-row">
								<div class="col-12 mt-3">
                                     <input type="submit" value="Update" class="btn btn-primary text-uppercase px-5 me-3">
								</div>
							</div>
						</form>
                            </validation-observer>
					</div>
					<div class="col-12 col-lg-5 col-xxl-7 text-center d-none d-lg-block">
						<img src="images/forgot-pass-img.png" alt="">
					</div>
				</div>
			</div>
		</section>
	</div>
</div>



</template>
<script>
	export default{
		data () {
		  return {
		    form:{},
		  };
		},
		methods: {
		  async update() {
		  	try {
		  		// statements
		  		let fd = new FormData();
		  		this.buildFormData(fd,this.form);
		    let {data} = await axios.post(route('admin.account.password'),fd);
			    if(data.status){
			    	this.$snotify.success(data.msg);
			    	this.$router.push({name : 'admin.account.index'});
			    }
		  	} catch(e) {
		  		// statements
		  		if(e.response){
                        console.log(e.response , "<<<<<<<<,");
		  				this.$snotify.error(e.response.data.msg);
		  		}
		  		console.log(e);
		  	}
		  }
		}
	}
</script>
