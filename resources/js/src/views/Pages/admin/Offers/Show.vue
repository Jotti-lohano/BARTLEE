<template>
    <div>
        
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{ name:'admin.offers.index'}"  class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Offer Details</router-link></h3>
            </div>
        </div>
    </div>

   <offer-info :detail="offer"> </offer-info>

   <!--  -->
   <offer-insights :offer="offer"></offer-insights>

    </div>
    </div>
</template>

<script>

import { mapActions, mapState } from 'vuex';

const OfferInfo = () => import('./components/OfferInfo.vue');
const OfferInsights = () => import('./components/OfferInsights.vue');
export default {
    components: {
        OfferInfo,
        OfferInsights
    },
    data : ()=> ({
        offer : {},
    }),
    async created(){
        await this.fetch();
    },
    methods : {
        ...mapActions('admin',['getAll','get']),
        async fetch(page = 1) {
			let params = {
				route: route('admin.offer.show',this.$route.params.id),
				 data: {
                }
			};
			let { data } = await this.get(params);
            this.offer = data.offer;
		},
        
    },
}
</script>

