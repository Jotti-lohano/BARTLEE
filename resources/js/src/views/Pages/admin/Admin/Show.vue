<template>
    <div>

<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{name : 'admin.admins.index'}"  class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>View Sub Admin Details</router-link></h3>
            </div>
        </div>
    </div>
        <show-admin></show-admin>
    </div>
    </div>
</template>


<script>

import { mapActions, mapState } from 'vuex';
const ShowAdmin = () => import('./components/Detail/ShowAdmin.vue');
export default {
    components: {
        ShowAdmin
    },
   
}

</script>