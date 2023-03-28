<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="d-flex justify-content-between shadow align-items-end p-3 my-4 flex-wrap">
                    <div class="totalUser">
                        <p class="mb-2">Total Users</p>
                        <p class="mb-0 font-weight-bold">{{detail.total_users}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between shadow align-items-end p-3 my-4 flex-wrap">
                    <div class="totalUser">
                        <p class="mb-2">Total Businesses</p>
                        <p class="mb-0 font-weight-bold">{{detail.total_businesses}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between shadow align-items-end p-3 my-4 flex-wrap">
                    <div class="totalUser">
                        <p class="mb-2">Total Badges</p>
                        <p class="mb-0 font-weight-bold">{{detail.total_badges}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { mapActions, mapState } from 'vuex';
export default {
    components: {
    },
    props : {
        detail : {
            type : Object,
            default : ()=> ({}),
        },
    },
    data() {
        return {
            users : {},
            cards:{
                totalUser:0,
                totalBusiness:0,
                totalBadges:0,
                lastTwoWeeks:0,
                avgUsers:0,
                lastTwoWeeksBusiness:0,
                avgBusiness:0

            },
            duration:{
                avgUsers:'all',
            },
        };
    },
    created() {
       
        this.fetch();
    },
    watch: {
    
        
        'duration.avgUsers': function(val, oldVal) {
            this.fetch();
        },
    },
    methods: {
        ...mapActions('admin', ['getAll']),
         async fetch() {
            let params = {
                route: route('admin.users.cards'),
                data: {
                    duration : this.duration.avgUsers,
                }
            };
            let { data } = await this.getAll(params);
            this.cards.totalUser = data.data.card.totalUser  || 0;
            this.cards.avgUsers = data.data.user.avgUsers || 0;
            this.cards.lastTwoWeeks = data.data.user.lastTwoWeeks || 0;
        },
    }
}

</script>