<template>
    <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-12">
                <div class="addPackages text-md-right">
                    <router-link :to="{name : 'admin.challenges.create', params : {type : 'request',id : this.$route.params.id} }" class="btn">Complete Request</router-link>
                </div>
            </div>
            <div class="d-flex justify-content-center flex-wrap align-items-center">
                <div class="titleHead text-center">
                    <figure class="mb-0">
                        <img src="admin-assets/images/white-beach.png" alt="" class="mw-100">
                    </figure>
                    <h3 class="h5 font-weight-bold" v-if="detail.business">{{detail.business.business_name}}</h3>
                    <h3 class="h5 font-weight-bold" v-if="!detail.business">No Name</h3>
                    <p class="mb-0" v-if="detail.business && detail.business.city">{{detail.business.city.name}}</p>
                </div>
            </div>
            <div class="col-md-7 m-auto my-3 pt-3">
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">User Name :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.business?detail.business.user.username:'N/A'}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Challenge Title :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.challenge_name}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Number of Visits :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.total_visits_required}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">No. of Followers :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.business?detail.business.user.followers_count:'0'}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Days:</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50" >{{detail.days.join(',')}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Reward:</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.challenge_reward || 0}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Dates:</p>
                    </div>
                    <div class="fieldData col-md-6 d-flex ">
                        <p class="mb-0 text-black-50">{{detail.challenge_starting_date}} &nbsp;</p>
                        <p class="mb-0 text-black-50">&mdash;&nbsp;{{detail.challenge_ending_date}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">No of Spots:</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.challenge_no_of_spots || 0}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props : {
        detail : {
            type : Object,
            default : ()=> ({}),
         },
    },
}
</script>