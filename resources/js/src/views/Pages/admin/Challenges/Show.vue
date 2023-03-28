<template>
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><a href="./challenges.php" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Challenges Details</a></h3>
            </div>
        </div>
    </div>
    <challenge-details v-if="$route.params.type == 'challenge'" :detail="detail"></challenge-details>
    <request-details v-if="$route.params.type == 'request'" :detail="detail" />
</div>    
</template>
<script>
import { mapActions } from 'vuex';
import ChallengeDetails from './Components/ChallengeDetails.vue';
import RequestDetails from './Components/RequestDetails.vue';
export default {
    components : {
        ChallengeDetails,
        RequestDetails,
    },
    async created(){
        this.type = this.$route.params.type;
        await this.fetch();
    },
    data : ()=> ({
        detail : {},
        type : 'challenge',
    }),
    methods : {
        ...mapActions('admin',['get']),
        async fetch(){
            let {data} = await this.get({
                route : route('admin.challenges.show',{id : this.$route.params.id,type : this.$route.params.type}),
                method : 'GET',
            });
            this.detail = data.data;
        },
    },
}
</script>