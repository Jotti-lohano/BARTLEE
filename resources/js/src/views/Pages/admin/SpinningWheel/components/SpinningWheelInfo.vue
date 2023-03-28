<template>
    <div>
          <div class="title mb-3">
        <h3 class="h5 achivpFont font-weight-bold">Rewards :</h3>
    </div>
    <div class="notification-section shadow p-5 rounded-15 my-4" v-for="(reward ,index) in rewards" :key="index">
        <div class="row justify-content-between">
            <div class="d-flex justify-content-between align-items-center gap-15">
                <div class="rewardBox flex-grow-1">
                    <div class="d-flex mb-3 flex-wrap align-items-center gap-15 ">
                        <div class="labelTitle flex-grow-1 col-md-3">
                            <p class="mb-0 font-weight-bold">Reward Name :</p>
                        </div>
                        <div class="fieldData col-md-3">
                            <p class="mb-0 text-black-50">{{reward.reward_name}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center gap-15 ">
                        <div class="labelTitle flex-grow-1 col-md-3">
                            <p class="mb-0 font-weight-bold">Reward :</p>
                        </div>
                        <div class="fieldData col-md-3 d-flex flex-wrap align-items-center gap-15">
                            <p class="mb-0 text-black-50">{{reward.reward}}</p>
                            <!-- <img :src="`../images/smile.png`" alt="Smile" class="w-100px"> -->
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center gap-15 ">
                        <div class="labelTitle flex-grow-1 col-md-3">
                            <p class="mb-0 font-weight-bold">Reward Type:</p>
                        </div>
                        <div class="fieldData col-md-3 d-flex flex-wrap align-items-center gap-15">
                            <p class="mb-0 text-black-50">{{reward.type}}</p>
                            <!-- <img :src="`../images/smile.png`" alt="Smile" class="w-100px"> -->
                        </div>
                    </div>
                </div>
                <div class="spinWheel flex-shrink-0">
                    <p class="mb-0"><router-link :to="{ name : 'admin.wheel.edit',params : {id : reward.id} }" class="text-dark fa-20"><i class="bi bi-pencil-square"></i></router-link> </p>
                </div>
            </div>
        </div>
    </div>
    <no-record :data="rewards.data">
        <h3 class="text-center">No Data Available</h3>
    </no-record>
    </div>
</template>



<script>
import { mapActions, mapState } from 'vuex';
export default {

    data() {
        return {
            rewards : {},
        };
    },
    created() {
        this.fetch();
    },
   
    methods: {
        
        ...mapActions('admin', ['getAll']),
        async fetch() {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.reward.index'),
                data: {
                    
                }
            };
            let { data } = await this.getAll(params);
            this.rewards = data.rewards;
        
        },
    }
}

</script>