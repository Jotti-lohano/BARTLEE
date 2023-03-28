<template>
    <div>

<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name : 'admin.admins.index'}" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Add Promotional Code</router-link> </h3>
            </div>
        </div>
    </div>
  
        <create-promos></create-promos>
    
    </div>
    </div>
</template>


<script>

import { mapActions, mapState } from 'vuex';

import CreatePromos from './components/Create/CreatePromos.vue';
export default {
    components: {
        CreatePromos
    },
   
}

</script>