<template>
    <div>

<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name : 'admin.promos.index'}"  class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Edit Promotional Code</router-link></h3>
            </div>
        </div>
    </div>
        <edit-promo></edit-promo>
    </div>
    </div>
</template>


<script>

import { mapActions, mapState } from 'vuex';
// const EditPromo = () => import('./components/Edit/EditPromo.vue');
import EditPromo from './components/Edit/EditPromo.vue';
export default {
    components: {
        EditPromo
    },
   
}

</script>