<template>
<div class="app-content content">
    <div class="content-wrapper">
        <!-- Basic form layout section start -->
        <section id="protfolio_page" class="profile-page">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <h2>Profile Information</h2>
                    </div>
                </div>
            </div>
            <div class="content-body shadow-sm bg-white rounded-10 p-4 p-lg-5">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-10">
                        <div class="detail-block media d-lg-flex d-block">
                            <div class="media-left flex-shrink-0 mb-5 mb-lg-0">
                                <!-- <div class="profile-img text-center m-auto m-md-0">
                                    <img src="images/profile-avatar.png" class="img-fluid ml-0" alt="">
                                </div> -->
                                        <div class="profile-img text-center m-auto m-md-0">
                                            <img id="profileImage" class="img-fluid ml-0" alt="" :src="$user.url" />
                                        </div>
                                
                            </div>
                            <div class="media-body flex-grow-1">
                                <div class="row mb-5">
                                    <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                        <label for="">First Name</label>
                                    </div>
                                    <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                        <p> {{$user.name}}</p>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                        <label for="">Last Name:</label>
                                    </div>
                                    <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                        <p>  {{$user.last_name}}</p>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                        <label for="">Email Address:</label>
                                    </div>
                                    <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                        <p> {{$user.email}}</p>
                                    </div>
                                </div>
                                <!-- <div class="row mb-5">
                                    <div class="col-12 col-lg-4 col-xl-4 col-xxl-3 lablename">
                                        <label for="">Phone Number:</label>
                                    </div>
                                    <div class="col-12 col-lg-8 col-xl-6 col-xxl-5">
                                        <p>+35699859200</p>
                                    </div>
                                </div> -->
                                <div class="row mb-3">
                                    <div class="col-12 mt-3 d-flex text-center">
                                        <div class="d-flex flex-column">
                                             <router-link :to="{name : 'admin.account.edit'}" class="btn btn-secondary">Edit Profile Information</router-link>
                                              <router-link :to="{name : 'admin.account.password'}" class="inline-link mt-3">
                                            <h5>Change Password</h5>
                                        </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

   
</template>
<script>
	
</script>