<template>
    <div>
        
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                    <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name : 'admin.boosts.index'}" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Boosts Details</router-link></h3>
                </div>
        </div>
    </div>

   <boosts-info> </boosts-info>

    </div>
    </div>
</template>

<script>

import { mapActions, mapState } from 'vuex';

const BoostsInfo = () => import('./components/Detail/BoostsInfo.vue');
export default {
    components: {
        BoostsInfo
    },
   
}

</script>

