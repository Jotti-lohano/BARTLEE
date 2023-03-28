<template>
        <div>
            <div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><a onclick="javascript:history.go(-1)" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Add Rewards</a></h3>
            </div>
        </div>
    </div>
            <create-spinning-wheel></create-spinning-wheel>
            </div>
        </div>
</template>


<script>

import { mapActions, mapState } from 'vuex';

const CreateSpinningWheel = () => import('./components/Create/CreateSpinningWheel.vue');
export default {
    components: {
        CreateSpinningWheel
    },
   
}
</script>