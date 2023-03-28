<template>

<div class="app-content content">
    <div class="content-wrapper">
        <!-- Basic form layout section start -->
        <section id="protfolio_edit_page" class="profile-edit-page">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <h2>                            
                            <router-link :to="{ name: 'admin.account.index'  }"><i class="fa fa-chevron-left"></i> Edit Profile Information
                            </router-link>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="content-body shadow-sm bg-white rounded-10 p-4 p-lg-5">
                <div class="detail-block media d-lg-flex d-block">
                    <div class="media-left flex-shrink-0 mb-5 mb-lg-0">
                        <div class="profile-img text-center m-auto m-md-0">
                            <div class="attached">
                                    <img v-if="userImage" :src="userImage" class="img-fluid ml-0"/>
                                    <img :src="$user.url" alt="" class="img-fluid ml-0" v-else>

                                    <button name="file" for="picture" class="btn camera-btn" onclick="document.getElementById('picture').click()">
                                    <i class="fa fa-camera"></i>
                                    </button>

                                    <form class="d-none">
                                        <input type="file" name="file" accept=".gif,.jpg,.png,.tif|image/*" @change="selected" id="picture">
                                        <input type="submit">
                                    </form>
                            </div>
                        </div>
                    </div>
                    <div class="media-body flex-grow-1 ps-0 ps-lg-5 ms-0 ms-lg-3">
                         <validation-observer v-slot="{handleSubmit}">
                            <form @submit.prevent="handleSubmit(update)">
                            <div class="row form-group">
                                <div class="col-12 col-lg-4 col-xl-3 col-xxl-3 align-self-center">
                                    <label class="fw-light">First Name<span class="text-black">*</span></label>
                                </div>
                            <validation-provider tag="div" rules="required|alpha" name="First Name" v-slot="{errors}" class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                            <input type="text" v-model="form.name" placeholder="Enter First Name" name="First Name" class="form-control">
                            <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>

                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-lg-4 col-xl-3 col-xxl-3 align-self-center">
                                    <label class="fw-light">Last Name<span class="text-black">*</span></label>
                                </div>
                               

                            <validation-provider tag="div" rules="required|alpha" name="Last Name" v-slot="{errors}" class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                            <input type="text" v-model="form.last_name" placeholder="Enter Last Name" name="Last Name" class="form-control">
                            <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>

                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-lg-4 col-xl-3 col-xxl-3 align-self-center">
                                    <label class="fw-light">Email Address<span class="text-black">*</span></label>
                                </div>
                                <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                    <input type="email" class="form-control" :Value="$user.email" readonly>
                                </div>
                            </div>
                            <!-- <div class="row form-group">
                                <div class="col-12 col-lg-4 col-xl-3 col-xxl-3 align-self-center">
                                    <label class="fw-light">Phone No<span class="text-black">*</span></label>
                                </div>
                                <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                    <input type="email" class="form-control" Value="+35699859200">
                                </div>
                            </div> -->
                            <div class="row detail-row">
                                <div class="col-12 mt-3">
                                    <input type="submit" value="Save Changes" class="btn btn-blue px-5 me-3">
                                    <!-- <a href="profile.php" class="btn btn-blue px-5 me-3">Save Changes</a> -->
                                     <router-link :to="{ name: 'admin.account.index'  }" class="btn btn-secondary px-5">Cancel
                            </router-link>
                                </div>
                            </div>
                        </form>
                         </validation-observer>
                    </div>
                </div>
            </div>
        </section>
    </div></div>   
</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
    data() {
        return {
            form: {
                name : '',
                last_name : '',
                file: null,
            },
            userImage: ''
        };
    },
    created(){
    	this.form.name = this.$user.name;
    	this.form.last_name = this.$user.last_name;
    },
    computed: {
        ...mapState('admin', ['admin']),
    },
    methods: {
        ...mapActions('admin', ['store', 'get']),

        onChange(e) {
                this.file = e.target.files[0];
            },


        async update() {
            let fd = new FormData();
            var file = document.getElementById("picture").files[0];
            if(typeof file != 'undefined'){
                if(file.size > 0){
                    fd.append('file', file);
                }
            }   
            fd.append('_method', 'PUT');
            // fd.append('file', this.file);
            this.buildFormData(fd, this.form);
            let params = {
                route: route('admin.account.update', { id : this.$user.id }),
                method: 'POST',
                data: fd,
            };
            try {
                let { data } = await this.store(params);
                if (data.status) {
                    this.$snotify.success(data.msg);
                     setTimeout(function() {
                location.reload();
                // self.$router.push({ name: 'admin.login' });
            }, 2000);
                    
                    // Vue.prototype.$user = data.user;
                    
                } else {
                    this.$snotify.error('something went wrong');
                }
            } catch (e) {
                if (e.response) {
                    this.$refs.adminObserver.setErrors(e.response.data.errors);
                }
                // statements
                console.log(e);
            }

        },
         async selected({ target: { files } }) {
            this.url = URL.createObjectURL(files[0]);
            this.userImage = this.url;
            console.log(this.userImage)
        },
    }
}

</script>
