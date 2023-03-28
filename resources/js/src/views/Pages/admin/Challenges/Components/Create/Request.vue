<template>
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name : 'admin.challenges.index'}" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Complex Challenge</router-link></h3>
            </div>
        </div>
    </div>
    <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-12 text-center">
                <figure class="mb-0">
                    <img src="admin-assets/images/logo.png" alt="Logo" class="mw-100 w-25">
                </figure>
                <h3 class="h4">UAE</h3>
            </div>
            <div class="col-md-10 m-auto my-3 pt-3">
                <validation-observer v-slot="{handleSubmit}" tag="div">
                    <form @submit.prevent="handleSubmit(create)" method="POST">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Requested By :</p>
                        </div>
                        <div v-if="detail.id" class="fieldData col-md-6">
                            {{detail.business.business_name || 'N/A'}}
                        </div>
                        <validation-provider v-if="!detail.id" name="challenge creator" tag="div" rules="required" v-slot="{errors}" class="fieldData col-md-6">
                            <v-select :options="businesses" v-model="form.business_id" :reduce="(item)=> item.id" label="business_name"></v-select>
                            <span class="text-danger">{{errors[0]}}</span>
                        </validation-provider>
                    </div>
                    <div v-if="detail.id" class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Request Detail:</p>
                        </div>
                        <div class="fieldData col-md-6">
                            {{detail.challenge_comment || 'N/A'}}
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Challange Title :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <input v-model="form.challenge_name" type="text" placeholder="Enter Challange Title" name="click" class="form-control pr-5 py-2 h-auto">
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Number of Visits :</p>
                        </div>
                        <validation-provider name="visits" tag="div" rules="required" v-slot="{errors}" class="fieldData col-md-6">
                            <input v-model="form.challenge_visits" type="number" placeholder="No of Visits" name="click" class="form-control pr-5 py-2 h-auto">
                            <span class="text-danger">{{errors[0]}}</span>
                        </validation-provider>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Days :</p>
                        </div>
                        <validation-provider tag="div" name="days" rules="required" v-slot="{errors}" class="fieldData col-md-6">
                            <select v-model="form.days" multiple name="days" id="days" class="form-select form-select-sm pr-5 py-2">
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                            <span class="text-danger">{{errors[0]}}</span>
                        </validation-provider>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Dates :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <div class="d-flex flex-column flex-wrap gap-15 align-items-center">
                                <validation-provider name="starting date" tag="div" rules="required" v-slot="{errors}" class="w-100 timeFeild flex-grow-1">
                                    <input v-model="form.challenge_starting_date" type="date" class="form-select form-select-sm py-2">
                                    <span class="text-danger">{{errors[0]}}</span>
                                </validation-provider>
                                <div class="between flex-shrink-0">
                                    <p class="mb-0">And</p>
                                </div>
                                <validation-provider name="ending date" tag="div" rules="required" v-slot="{errors}" class="w-100 timeFeild flex-grow-1">
                                    <input v-model="form.challenge_ending_date" type="date" class="form-select form-select-sm py-2">
                                    <span class="text-danger">{{errors[0]}}</span>
                                </validation-provider>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Timing :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <div class="d-flex flex-wrap gap-15 align-items-center">
                                <validation-provider name="starting time" tag="div" rules="required" v-slot="{errors}" class="timeFeild flex-grow-1">
                                    <input v-model="form.challenge_starting_time" type="time" class="form-select form-select-sm py-2">
                                    <span class="text-danger">{{errors[0]}}</span>
                                </validation-provider>
                                <div class="between flex-shrink-0">
                                    <p class="mb-0">And</p>
                                </div>
                                <validation-provider name="ending time" tag="div" rules="required" v-slot="{errors}" class="timeFeild flex-grow-1">
                                    <input v-model="form.challenge_ending_time" type="time" class="form-select form-select-sm py-2">
                                    <span class="text-danger">{{errors[0]}}</span>
                                </validation-provider>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Reward :</p>
                        </div>
                        <validation-provider name="reward" tag="div" rules="required" v-slot="{errors}" class="fieldData col-md-6 d-flex flex-wrap align-items-center gap-15">
                            <input v-model="form.challenge_reward" type="number" placeholder="Rewards" name="reward" class="form-control pr-5 py-2 h-auto w-75">
                            <img src="admin-assets/images/smile.png" alt="smiles" class="w-100px">
                            <span class="text-danger">{{errors[0]}}</span>
                        </validation-provider>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Number of Spots :</p>
                        </div>
                        <validation-provider name="spots" tag="div" rules="required" v-slot="{errors}" class="fieldData col-md-6">
                            <input v-model="form.challenge_no_of_spots" type="number" placeholder="spots" name="No of Spots" class="form-control pr-5 py-2 h-auto">
                            <span class="text-danger">{{errors[0]}}</span>
                        </validation-provider>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Branches To Be Added :</p>
                        </div>
                        <validation-provider name="businesses" tag="div" rules="required" v-slot="{errors}" class="fieldData col-md-6">
                            <v-select :options="businesses" v-model="selectedBusinesses" multiple label="business_name"></v-select>
                            <span class="text-danger">{{errors[0]}}</span>
                        </validation-provider>
                    </div>
                    <div class="submitBtn text-center pt-5">
                        <input type="submit" value="ADD" class="submitStyle border-0 rounded-15 px-5">
                    </div>
                </form>
                </validation-observer>
            </div>
        </div>
    </div>
</div>    
</template>
<script>
import { mapActions } from 'vuex';

export default {
    data : ()=> ({
        detail : {},
        form : {
            days : [],
        },
        businesses : [],
        selectedBusinesses : [],
    }),
    async created(){
        await this.fetch();
        await this.fetchBusinesses();
    },
    methods : {
        ...mapActions('admin',['get','store']),
        async create(){
            let fd = new FormData();
            let form = this.form;
            delete form.business;
            this.buildFormData(fd,form);
            let businesses = _.map(this.selectedBusinesses,'id')
            this.buildFormData(fd,businesses,'businessess');
            if(this.detail.id){
                fd.append('challenge_id',this.detail.id);
            }
            let type = this.$route.params.type == 'request'?'complex':'simple';

            fd.append('challenge_type',type);
            let {data} = await this.store({
                route : route('admin.challenges.store'),
                data : fd,
            });
            if(data.status){
                this.$snotify.success(data.message);
                this.$router.push({name : 'admin.challenges.index'});
            }
        },
        async fetchBusinesses(){
            // await 
            let {data} = await this.get({
                route : route('admin.users.businesses',{id : this.$route.params.id}),
                method : 'get',
            });
            this.businesses = data.users;
            
        },
        async fetch(){
            if(this.$route.params.id){

                let {data} = await this.get({
                    route : route('admin.challenges.show',{challenge : this.$route.params.id }),
                    method : 'get',
            });
            this.detail = data.data;
            this.form = JSON.parse(JSON.stringify(this.detail));
            }
        },
    },
}
</script>