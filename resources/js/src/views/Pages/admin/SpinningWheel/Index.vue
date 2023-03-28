<template>
    <div>
        
        <div class="userSection">
    <div class="d-flex align-items-center justify-content-between my-4 flex-wrap px-3">
        <div class="titleBox">
            <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Spinning Wheel</h3>
        </div>
        <div class="addPackages">
             <router-link :to="{name : 'admin.wheel.create'}" class="btn">Add Reward</router-link>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4 m-auto">
            <div class="contentBox registerdUser border my-3">
                <div class="d-flex jusify-content-between flex-wrap flex-lg-nowrap align-items-center">
                    <p class="flex-grow-1 mb-0">Number of Spins</p>
                     <select  v-model="duration.spins"  class="form-select form-select-sm pr-5 py-2 w-auto" aria-label=".form-select-sm example">
                        <option selected value="all">All</option>
                        <option  value="1">Today</option>
                        <option value="7">7 Days</option>
                        <option value="30">30 Days</option>
                    </select>
                </div>
                <div class="contentStats h-100">
                   <h3 class="h1">{{cards.spins}}</h3>
                </div>
            </div>
        </div>
    </div>
   <spinning-wheel-info> </spinning-wheel-info>

</div>

    </div>
</template>



<script>
const SpinningWheelInfo = () => import('./components/SpinningWheelInfo.vue');
import { mapActions, mapState } from 'vuex';
export default {
    components: {
        SpinningWheelInfo
    },
    data : ()=> ({
        packages : {},
        cards:{ 
            spins:0,
    
        },
        duration:{
            spins:'all',
        },
    }),
	created() {
        this.fetchSmileCard();
	},
     watch: {
         'duration.spins': function(val, oldVal) {
            this.fetchSmileCard();
        }
     },
	methods: {
		...mapActions('admin', ['getAll']),
         async fetchSmileCard() {
    
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.spins_reward'),
                data: {
                    duration : this.duration.spins,
                }
            };
            let { data } = await this.getAll(params);
            this.cards.spins = data.spins || 0;
        },
	},
}

</script>
