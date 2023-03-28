<template>
    <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
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
                        <p class="mb-0 font-weight-600">Type of Challenge :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.challenge_type}}</p>
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
                        <p class="mb-0 font-weight-600">No of Spots:</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.challenge_no_of_spots || 0}}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- tabs -->
    <div class="row packages py-4">
        <div class="col-md-12">
            <ul class="nav nav-tabs d-flex flex-wrap justify-content-center align-items-center gap-15 border-0 text-center" id="myTab" role="tablist">
                <li class="nav-item flex-grow-1 shadow border-0">
                    <a @click="changePreview('started')" href="javascript:void(0)" class="nav-link" :class="{active : componentName == 'started'}" role="tab" aria-controls="business" aria-selected="false">Started</a>
                </li>
                <li class="nav-item flex-grow-1 shadow border-0">
                    <a @click="changePreview('completed')" class="nav-link" :class="{active : componentName == 'completed'}" href="javascript:void(0)" role="tab" aria-controls="purchase" aria-selected="true">Completed</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tab-content" id="myTabContent">
                <component :challenge="detail" :is="`tab-${componentName}`"/>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
import TabStarted from '../Components/Tabs/Started.vue';
import TabCompleted from '../Components/Tabs/Completed.vue';
export default {
    props : {
        detail : {
            type : Object,
            default : ()=> ({}),
         },
    },
    components : {
        TabCompleted,
        TabStarted,
    },
    data : ()=> ({
        componentName : 'started',
    }),
    methods : {
        changePreview(componentName){
            this.componentName = componentName;
        }
    },
}
</script>