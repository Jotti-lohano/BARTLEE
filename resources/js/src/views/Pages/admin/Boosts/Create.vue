<template>
        <div>
            <div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name : 'admin.boosts.index'}" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Add Boosts</router-link></h3>
            </div>
        </div>
    </div>

            <create-boosts></create-boosts>
            </div>
        </div>
</template>


<script>

import { mapActions, mapState } from 'vuex';

const CreateBoosts = () => import('./components/Create/CreateBoosts.vue');
export default {
    components: {
        CreateBoosts
    },
   
}

</script>