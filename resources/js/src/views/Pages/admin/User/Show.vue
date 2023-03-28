<template>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Basic form layout section start -->
            <user-detail :detail="user" v-if="$route.params.type == 'attendee'"></user-detail>
            <patient-detail :detail="user" v-if="$route.params.type == 'patient'"></patient-detail>
            <!-- <user-edit v-if="$route.params.type == 'edit'" @on-update="fetch"></user-edit> -->
        </div>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import UserDetail from './components/UserDetail.vue';
import PatientDetail from './components/PatientDetails.vue';

export default {
    computed: {
    },
    components: {
        UserDetail,
        PatientDetail,
    },
    async created() {
         this.type = this.$route.params.type; 
        let { page } = this.$route.query;
        await this.fetch(page);
    },
    watch: {
      search: function(val, oldVal) {
      	this.fetch();
      },
      visitor_duration(val){
          this.fetch();
      },
    },
    data () {
      return {
        user : {},
        type:'',
        application:{},
        visitor_duration : 'all',
      };
    },
    methods: {
        ...mapActions('admin', ['getAll']),
        async fetch(page = 1) {
            
            let { user,type } = this.$route.params;
            let params = {
                route: route('admin.user.show',{ user,type,visitor_duration : this.visitor_duration }),
                // mutation: 'SET_USER',
                // variable: 'user',
            };
            let { data } = await this.getAll(params);
            this.user = data.user;
        }
    }
}

</script>
