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
                            <div class="right">
                                <div class="logo text-center">
                                    <img src="images/logo.png" alt="" />
                                </div>
                                <h1 class="mb-5 mt-5">Login</h1>
                                <validation-observer v-slot="{ handleSubmit }" class="col-12">
                                    <form @submit.prevent="handleSubmit(login)">

                                        <validation-provider tag="div" rules="required" v-slot="{ errors }"
                                            class="form-group">
                                            <label for="">Email Address<span class="text-black">*</span></label>
                                            <input type="email" v-model="form.email" name="Email"
                                                placeholder="Enter Email Address" class="form-control">
                                            <span class="text-red">{{ errors[0] }}</span>
                                        </validation-provider>

                                        <div class="form-group mb-1">
                                            <label for="">Password<span class="text-black">*</span> </label>
                                            <validation-provider tag="div" rules="required" v-slot="{ errors }"
                                                class="position-relative">
                                                <input ref="password" type="password" v-model="form.password"
                                                    class="form-control  enter-input" id="password"
                                                    placeholder="Enter Password">
                                                <button class="btn view-btn position-absolute"
                                                    onclick="event.preventDefault()">
                                                    <i class="fa fa-eye-slash enter-icon right-icon"
                                                        @click="togglePasswordType('password')" aria-hidden="true">></i>
                                                </button>
                                                <span class="text-red">{{ errors[0] }}</span>
                                            </validation-provider>
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="remember-pass">
                                                    <label class="login-check">Remember Me
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="forgot-pass">
                                                    <router-link :to="{ name: 'admin.pr.email' }"
                                                        class="theme-primary-text">Forgot Password?</router-link>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group text-center mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary btn-login">Login</button>
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
            response: {},
            form: {
                email: '',
                password: '',
            }
        };
    },
    methods: {
        async login(e) {
            let fd = new FormData();
            this.buildFormData(fd, this.form);
            try {
                let response = await axios.post(route('admin.auth.login'), fd);
                if (response.data.status) {
                    console.log('test1')
                    this.$snotify.success(response.data.msg)
                    let self = this;
                    setTimeout(function () {
                        window.location.reload();
                        // self.$router.push({ name: 'admin.dashboard' });
                    }, 2000);
                } else {
                    console.log('test2')
                    this.$snotify.error(response)

                }
                this.response = {}
            } catch (e) {
                if (e.response) {
                    console.log(e.response.data.msg)
                    this.$snotify.error(e.response.data.msg)
                    this.response = e.response.data
                }
                console.log(e);
            }
        }
    }
}

</script>
