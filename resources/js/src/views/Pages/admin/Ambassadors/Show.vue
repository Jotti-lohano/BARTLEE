<template>
    <div>
    <div class="userSection">
    <div class="titleBox py-4">
        <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name :'admin.ambassadors.index'}" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Ambassadors Details</router-link></h3>
    </div>
   <ambassador-info ></ambassador-info>
  <!--  -->
  <ambassador-details ></ambassador-details>
</div>
    </div>
</template>


<script>
import { mapActions, mapState } from 'vuex';
const AmbassadorDetails = () => import('./components/Detail/AmbassadorDetails.vue');
const AmbassadorInfo = () => import('./components/Detail/AmbassadorInfo.vue');
export default {
    components: {
        AmbassadorInfo,
        AmbassadorDetails,
    },
   
}

</script>

