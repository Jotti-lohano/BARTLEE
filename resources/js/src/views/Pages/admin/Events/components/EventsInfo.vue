<template>
    <div>
          <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="d-flex justify-content-center flex-wrap align-items-center">
                <div class="titleHead text-center">
                    <figure class="mb-0">
                        <img :src="`${detail.avatar_img}`" alt="" class="mw-100">
                    </figure>
                    <h3 class="h5 font-weight-bold">{{detail.business_name}}</h3>
                    <p class="mb-0">Dubai</p>
                  
                </div>
            </div>
            <div class="col-md-7 m-auto my-3 pt-3">
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Busniess Username :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">  {{detail.username}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Event Title :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">  {{detail.event_name}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Starting Date :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">  {{detail.event_starting_date}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Starting Time :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.event_starting_time}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Ending Date :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.event_ending_date}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Ending Time :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.event_ending_time}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Description :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.event_description}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Image :</p>
                    </div>
                    <div class="fieldData col-md-6" v-if="detail.media != null">
                        <p class="mb-0 text-black-50"><img class="w-100" draggable="false" :src="detail.media.file_url" /></p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    </div>
</template>


<script>
import {mapActions} from 'vuex';
export default {
    props : {
        detail : {
            type : Object,
            default : ()=> ({}),
        },
    },
}
</script>