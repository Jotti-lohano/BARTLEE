<template>
    <div>
        
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{ name:'admin.events.index'}" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Events Details</router-link></h3>
            </div>
        </div>
    </div>

         <events-info :detail="detail"> </events-info>

         <!-- Tabs -->

          <!-- tabs -->
    <div class="row packages py-4">
        <div class="col-md-12">
            <ul class="nav nav-tabs d-flex flex-wrap justify-content-center align-items-center gap-15 border-0 text-center" id="myTab" role="tablist">
                <li class="nav-item flex-grow-1 shadow border-0">
                    <a class="nav-link active" id="business-tab" data-toggle="tab" href="#business" role="tab" aria-controls="business" aria-selected="false">Attendend</a>
                </li>
                <li class="nav-item flex-grow-1 shadow border-0">
                    <a class="nav-link" id="purchase-tab" data-toggle="tab" href="#purchase" role="tab" aria-controls="purchase" aria-selected="true">Saved</a>
                </li>
            </ul>
        </div>
        <events-stats :event="detail"/>
    </div>

    </div>
    </div>
</template>

<script>

import { mapActions, mapState } from 'vuex';
import EventsStats from './components/EventsStats.vue';

const EventsInfo = () => import('./components/EventsInfo.vue');
export default {
    components: {
        EventsInfo,
        EventsStats
    },
    data : ()=> ({
        detail : {},
    }),
    async created(){
        await this.fetch();
    },
    methods : {
        ...mapActions('admin',['getAll','get']),
        async fetch(page = 1) {
			let params = {
				route: route('admin.event.show',this.$route.params.id),
				 data: {
                }
			};
			let { data } = await this.get(params);
            this.detail = data.event;
		},
        
    },
   
}

</script>

