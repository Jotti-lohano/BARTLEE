<template>
    <div>
        <div class="userSection">
            <ambassadors-listings> </ambassadors-listings>
            <!-- <reward-listings></reward-listings> -->
            </div>

    </div>
</template>



<script>

import { mapActions, mapState } from 'vuex';

const AmbassadorsListings = () => import('./components/AmbassadorsListings.vue');

const RewardListings = () => import('./components/RewardListings.vue');
export default {
    components: {
        AmbassadorsListings,
        RewardListings
    },
}
</script>


