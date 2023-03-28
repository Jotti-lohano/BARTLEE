<template>
    <div>

<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name : 'admin.promos.index'}"  class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>View Promotional Code</router-link></h3>
            </div>
        </div>
    </div>
        <show-promos></show-promos>
    </div>
    </div>
</template>


<script>

import { mapActions, mapState } from 'vuex';
// const ShowPromos = () => import('./components/Detail/ShowPromos.vue');
import ShowPromos from './components/Detail/ShowPromos.vue';
export default {
    components: {
        ShowPromos
    },
   
}

</script>