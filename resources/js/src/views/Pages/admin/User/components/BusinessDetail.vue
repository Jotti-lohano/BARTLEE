<template>
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox border-bottom py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name : 'admin.users.index', params : {type : 'business'} }" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Business Details</router-link></h3>
            </div>
        </div>
    </div>
    <div class="information-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="d-flex justify-content-between flex-wrap align-items-center">
                <div class="titleHead">
                    <h3 class="h5 font-weight-bold">General Information :</h3>
                </div>
                <div class="statusBox">
                    <p class="text-success mb-0">{{detail.status_detail}}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Name :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.name || 'NA'}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">User Name :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.username}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Email :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.email}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Date of Birth :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.dob}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Mobile Number :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.phone}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">No. of Followers :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.followers_count}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">No. of Follows :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.followings_count}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Registration Date :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{formatDate(detail.created_at)}}</p>
                    </div>
                </div>
                <!-- <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Current Location :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">FGGGHHJ</p>
                    </div>
                </div> -->
            </div>
            <div class="col-md-12 my-3">
                <div class="titleHead">
                    <h3 class="h5">Bio :</h3>
                </div>
                <div class="contentBio">
                    <p class="mb-0">{{detail.bio || "N/A"}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="business-section shadow p-5 rounded-15 my-4" v-if="detail.business_user">
        <div class="row justify-content-between align-items-center">
            <div class="titleHead">
                <h3 class="h5 font-weight-bold">Business Information :</h3>
            </div>
            <div class="col-md-6 text-center">
                <figure class="mb-0">
                    <img src="admin-assets/images/circle-icon.png" alt="user image" class="mw-100">
                </figure>
            </div>
            <div class="col-md-6">
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Name :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.business_user.business_name || 'N/A'}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Address :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.business_user.address || 'N/A'}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Website :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.business_user.website || 'N/A'}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Instagram Link :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.instagram_link || 'N/A'}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Contact Email Address :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.business_user.contact_email_address}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Business Plan :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.business_user.packages?detail.business_user.packages[0].package_name:'N/A'}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 my-3">
                <div class="titleHead">
                    <h3 class="h5 font-weight-bold">Images :</h3>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-15">
                    <div :key="imageIndex" v-for="(image,imageIndex) in detail.images" class="imageBox my-2">
                        <img draggable="false" :src="image.file_url" alt="image" class="mw-100">
                    </div>
                    <no-record :data="detail.images">0 Images found</no-record>
                </div>
            </div>
            <div class="col-md-12 my-3">
                <div class="titleHead">
                    <h3 class="h5 font-weight-bold">Menu :</h3>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-15">
                    <div :key="menuIndex" v-for="(menu,menuIndex) in detail.menus" class="imageBox my-2">
                        <img draggable="false" :src="menu.file_url" alt="image" class="mw-100">
                    </div>
                    <no-record :data="detail.menus">0 Menus found</no-record>
                </div>
            </div>
            <div class="col-md-12 my-3">
                <div class="titleHead">
                    <h3 class="h5 font-weight-bold">Timings :</h3>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-15">
                    <div :key="scheduleIndex" v-for="(schedule,scheduleIndex) in detail.business_user.schedule" class="timeCard flex-grow-1 bg-light p-3 rounded-15">
                        <div class="d-flex timingCard my-2">
                            <div class="col-md-4 px-md-0">
                                <p class="mb-0 font-weight-bold">Day :</p>
                            </div>

                            <div class="col-md-8 px-md-0">
                                <p class="mb-0 text-capitalize">{{schedule.day}}</p>
                            </div>
                        </div>
                        <div class="d-flex timingCard my-2">
                            <div class="col-md-4 px-md-0">
                                <p class="mb-0 font-weight-bold">Time :</p>
                            </div>

                            <div class="col-md-8 px-md-0">
                                <p class="mb-0">{{formatDate(`${new Date().toDateString()} ${schedule.start_time}`,'hh:mm A')}} - {{formatDate(`${new Date().toDateString()} ${schedule.end_time}`,'hh:mm A')}}</p>
                            </div>
                        </div>
                    </div>
                    <no-record :data="detail.business_user.schedule">0 timings found</no-record>
                </div>
            </div>
            <div class="col-md-12 my-3">
                <div class="titleHead">
                    <h3 class="h5 font-weight-bold">Badge :</h3>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-15">
                    <div class="imageBox my-2">
                        <img :src="detail.business_user?detail.business_user.badge_media.file_url:''" alt="image" class="mw-100">
                    </div>
                </div>
            </div>
            <div class="col-md-12 my-3">
                <div class="titleHead">
                    <h3 class="h5 font-weight-bold">Smiles :</h3>
                </div>
                <div class="smileContent my-2 d-flex align-items-center flex-wrap gap-15">
                    <p class="mb-0">Current sMiles :</p>
                    <p class="mb-0">{{detail.smiles_balance}}</p>
                </div>
            </div>
            <div class="col-md-12 my-3">
                <div class="titleHead">
                    <h3 class="h5 font-weight-bold">Groups :</h3>
                </div>
                <div :key="groupIndex" v-for="(group,groupIndex) in detail.business_user.groups" class="d-flex flex-wrap align-items-center gap-15">
                    <!-- <div class="badge-box">
                        <div class="contentBadge text-center">
                            <figure>
                                <img :src="group.media?group.media.file_url:''" class="mw-100 w-25 h-25"  alt="">
                            </figure>
                            <h4 class="font-weight-bold mb-1 h5 mb-1">{{group.name}}</h4>
                        </div>
                    </div> -->
                    <div class="badge-box">
                        <div class="contentBadge text-center">
                            <figure>
                                <img class="mw-100 rounded-circle w-25 h-25" :src="group.media?group.media.file_url:'admin-assets/images/badge-default.png'" alt="">
                            </figure>
                            <h4 class="font-weight-bold mb-1 h5 mb-1">{{group.business_name}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 my-3">
                <div class="titleHead">
                    <h3 class="h5 font-weight-bold">Top Visitors :</h3>
                </div>
                <div class="smileContent my-2 d-flex align-items-center flex-wrap gap-15">
                    <p :key="visitorIndex" v-for="(visitor,visitorIndex) in detail.top_visitors" class="mb-0">{{visitor.name}}</p>
                    <no-record :data="detail.top_visitors">0 top visitors found</no-record>
                </div>
                <div class="contentBox registerdUser border my-3 col-md-4">
                    <div class="d-flex jusify-content-between flex-wrap flex-lg-nowrap align-items-center">
                        <p class="flex-grow-1 mb-0">Total Visitors</p>
                        <select v-model="visitor_duration" class="form-select form-select-sm pr-5 py-2 w-auto" aria-label=".form-select-sm example">
                            <option value="all">All</option>
                            <option value="1">Today</option>
                            <option value="7">7 Days</option>
                            <option value="30">30 Days</option>
                        </select>
                    </div>
                    <div class="contentStats h-100">
                        <h3 class="h1">{{detail.business_user.total_visits}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="did-section shadow p-5 rounded-15 my-4" v-if="detail.business_user">
        <div class="row">
            <div class="col-md-12">
                <div class="titleHead mb-3">
                    <h3 class="h5 font-weight-bold">
                        Did You know :</h3>
                </div>
            </div>
            <div  :key="factIndex" v-for="(fact,factIndex) in detail.business_user.facts" class="col-md-4">
                <div class="total-box-dotted text-left d-flex flex-column flex-column px-5 justify-content-center">
                    <p class="poppins mb-0">{{fact.value}}</p>
                </div>
            </div>
            <p class="text-md-right">
                <!-- <a href="#" class="text-decoration-none theme-primary-text">View More</a> -->
            </p>
        </div>
    </div>
</div>
</template>
<script>
import { mapState ,mapActions} from 'vuex';
export default {
    props: {
        detail : {
            type : Object,
            default : ()=> ({}), 
        },
    },
    data : ()=> ({
        visitor_duration : 'all',
    }),
    async created(){
        await Promise.all(
            [
                // this.fetch()
            ]
        )
    },
    watch: {
      visitor_duration(val){
          this.$emit('on-visitor-duration-update',val);
      },
    },
    methods: {
        ...mapActions('admin',['get']),
        async fetchBadges(isLoadMore = true){
            if(!isLoadMore){

                this.badges_currentPage--;
                if(this.badges_currentPage <= 0)
                    this.badges_currentPage = 1;
            }
            let {data} = await this.get({
                route : route('admin.users.badges',{id : this.$route.params.user}),
                data : {
                    page : this.badges_currentPage,                    
                    duration : this.badges_duration
                }
            });
            this.badges = data.badges;
            this.badges_count = data.badges_count;
            if(isLoadMore){

                this.badges_currentPage++;
            }
        },
        async fetchchallengeStats(type){
            this[`${type}_total`] = 1;
            let {data} = await this.get({
                route : route('admin.users.challengeStats',{id : this.$route.params.user}),
                data : {
                    type,
                    page : this[`${type}_currentPage`],
                    
                }
            });
            this[`${type}_currentPage`]++;
            this[`${type}_challenges`] = data;
        },
        async fetchEvents(type){
            this[`events_${type}_total`] = 1;
            let {data} = await this.get({
                route : route('admin.users.events',{id : this.$route.params.user}),
                data : {
                    type,
                    page : this[`${type}_currentPage`],
                    
                }
            });
            this[`events_${type}_currentPage`]++;
            this[`${type}_events`] = data;
        },
        async fetchOffers(){
            let {data} = await this.get({
                route : route('admin.users.offers',{id : this.$route.params.user}),
                data : {
                    page : this.offers_currentPage,
                    
                }
            });
            this.offers =  data;
            this.offers_total = data.total;
            this.offers_currentPage++;
        },
    	showLoadMore(actual_length, current_length){
            if(actual_length > 5){
                return true;
            }else{
                return false;
            }
        }
    
    }
}
</script>
