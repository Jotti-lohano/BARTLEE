<template>
  <div class="packages">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Finance</h3>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="contentBox registerdUser border my-3">
                <div class="d-flex jusify-content-between flex-wrap flex-lg-nowrap align-items-center">
                    <p class="flex-grow-1 mb-0">Revenue From Registration</p>
                    <select  v-model="duration.registration"  class="form-select form-select-sm pr-5 py-2 w-auto" aria-label=".form-select-sm example">
                        <option selected value="all">All</option>
                        <option  value="1">Today</option>
                        <option value="7">7 Days</option>
                        <option value="30">30 Days</option>
                    </select>
                </div>
                <div class="contentStats h-100">
                    <h3 class="h1">{{cards.registrations}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="contentBox registerdUser border my-3">
                <div class="d-flex jusify-content-between flex-wrap flex-lg-nowrap align-items-center">
                    <p class="flex-grow-1 mb-0">Revenue From sMiles</p>
                     <select v-model="duration.smile" class="form-select form-select-sm pr-5 py-2 w-auto" aria-label=".form-select-sm example">
                        <option selected value="all">All</option>
                        <option  value="1">Today</option>
                        <option value="7">7 Days</option>
                        <option value="30">30 Days</option>
                    </select>
                </div>
                <div class="contentStats h-100">
                    <h3 class="h1">{{cards.smiles}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="contentBox registerdUser border my-3">
                <div class="d-flex jusify-content-between flex-wrap flex-lg-nowrap align-items-center">
                    <p class="flex-grow-1 mb-0">Revenue From Reports</p>
                    <select v-model="duration.report"  class="form-select form-select-sm pr-5 py-2 w-auto" aria-label=".form-select-sm example">
                       <option selected value="all">All</option>
                        <option  value="1">Today</option>
                        <option value="7">7 Days</option>
                        <option value="30">30 Days</option>
                    </select>
                </div>
                <div class="contentStats h-100">
                   <h3 class="h1">{{cards.reports}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="contentBox registerdUser border my-3">
                <div class="d-flex jusify-content-between flex-wrap flex-lg-nowrap align-items-center">
                    <p class="flex-grow-1 mb-0">Revenue From Boosts</p>
                    <select v-model="duration.boost"  class="form-select form-select-sm pr-5 py-2 w-auto" aria-label=".form-select-sm example">
                        <option selected value="all">All</option>
                        <option  value="1">Today</option>
                        <option value="7">7 Days</option>
                        <option value="30">30 Days</option>
                    </select>
                </div>
                <div class="contentStats h-100">
                   <h3 class="h1">{{cards.boosts}}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="tabsBar my-5">
        <ul class="nav nav-tabs d-flex flex-wrap justify-content-center align-items-center gap-15 border-0 text-center" id="myTab" role="tablist">
            <li class="nav-item flex-grow-1 shadow border-0">
                <a class="nav-link"  @click="changePreview('registration')" :class="{active : ($route.params.type == 'registration')}" id="business-tab" data-toggle="tab" href="#business" role="tab" aria-controls="business" aria-selected="false">Registration</a>
            </li>
            <li class="nav-item flex-grow-1 shadow border-0">
                <a class="nav-link" @click="changePreview('smiles')" :class="{active : ($route.params.type == 'smiles')}"   id="purchase-tab" data-toggle="tab" href="#purchase" role="tab" aria-controls="purchase" aria-selected="true">Smiles</a>
            </li>
            <li class="nav-item flex-grow-1 shadow border-0">
                <a class="nav-link"  @click="changePreview('reports')" :class="{active : ($route.params.type == 'reports')}"  data-toggle="tab" href="#smiles" role="tab" aria-controls="smiles" aria-selected="false">Reports</a>
            </li>
            <li class="nav-item flex-grow-1 shadow border-0">
                <a class="nav-link"  @click="changePreview('boosts')" :class="{active : ($route.params.type == 'boosts')}"  data-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">Boosts</a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="myTabContent">

         <component :is="`${componentName}-tab`"/>

    </div>
</div>

</template>

<script>
import RegistrationTab from './Components/RegistrationTab.vue';
import SmilesTab from './Components/SmilesTab.vue';
import ReportsTab from './Components/ReportsTab.vue';
import BoostsTab from './Components/BoostsTab.vue';
import { mapActions, mapState } from 'vuex';
export default {
    components : {
        RegistrationTab,
        SmilesTab,
        ReportsTab,
        BoostsTab
    },
    data : ()=> ({
        packages : {},
        cards:{ 
            registrations:0,
            reports:0,
            boosts:0,
            smiles:0,
        },
        duration:{
            smile:'all',
            boost:'all',
            registration:'all',
            report:'all'
        },
        componentName : 'registration',
    }),
	created() {

		this.componentName = this.$route.params.type;
        this.fetchSmileCard();
        this.fetchRegistrationCard();
        this.fetchBoostsCard();
          this.fetchReportsCard();
    
	},
     watch: {
         'duration.smile': function(val, oldVal) {
            this.fetchSmileCard();
        },
         'duration.registration': function(val, oldVal) {
             this.fetchRegistrationCard();
        },
         'duration.boost': function(val, oldVal) {
             this.fetchBoostsCard();
        },
        'duration.report': function(val, oldVal) {
             this.fetchReportsCard();
        },
        
     },
	methods: {
		...mapActions('admin', ['getAll']),
        changePreview(name){
        
            this.$router.push({name : 'admin.payments.index',params : {type : name}});
            this.componentName = name;
        },

         async fetchSmileCard() {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.finance.smile.show',0),
                data: {
                    duration : this.duration.smile,
                }
            };
            let { data } = await this.getAll(params);
            this.cards.smiles = data.smiles.total_amount || 0;
        },
         async fetchRegistrationCard() {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.finance.registration.show',0),
                data: {
                    duration : this.duration.registration,
                }
            };
            let { data } = await this.getAll(params);
            this.cards.registrations = data.registrations || 0;
        },

          async fetchBoostsCard() {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.finance.boost.show',0),
                data: {
                    duration : this.duration.boost,
                }
            };
            let { data } = await this.getAll(params);
            this.cards.boosts = data.boosts || 0;
        },
        async fetchReportsCard() {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.finance.report.show',0),
                data: {
                    duration : this.duration.report,
                }
            };
            let { data } = await this.getAll(params);
            this.cards.reports = data.reports || 0;
        },
	},
}

</script>