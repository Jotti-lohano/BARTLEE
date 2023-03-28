<template>
  <div class="packages">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Configration</h3>
            </div>
        </div>
    </div>
    <div class="tabsBar my-5">
        <ul class="nav nav-tabs d-flex flex-wrap justify-content-center align-items-center gap-15 border-0 text-center" id="myTab" role="tablist">
            <li class="nav-item flex-grow-1 shadow border-0">
                <a class="nav-link"  @click="changePreview('account-category')" :class="{active : ($route.params.type == 'account-category')}" id="business-tab" data-toggle="tab" href="#business" role="tab" aria-controls="business" aria-selected="false">Account Category</a>
            </li>
            <li class="nav-item flex-grow-1 shadow border-0">
                <a class="nav-link" @click="changePreview('business-type')" :class="{active : ($route.params.type == 'business-type')}"   id="purchase-tab" data-toggle="tab" href="#purchase" role="tab" aria-controls="purchase" aria-selected="true">Business Type</a>
            </li>
            <li class="nav-item flex-grow-1 shadow border-0">
                <a class="nav-link"  @click="changePreview('stickers')" :class="{active : ($route.params.type == 'stickers')}"  data-toggle="tab" href="#smiles" role="tab" aria-controls="smiles" aria-selected="false">Stickers</a>
            </li>
            <li class="nav-item flex-grow-1 shadow border-0">
                <a class="nav-link"  @click="changePreview('push-announcements')" :class="{active : ($route.params.type == 'push-announcements')}"  data-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">Push Announcements </a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="myTabContent">

         <component :is="`${componentName}-tab`"/>

    </div>
</div>

</template>

<script>
import AccountCategoryTab from './Components/AccountCategoryTab.vue';
import BusinessTypeTab from './Components/BusinessTypeTab.vue';
import PushAnnouncementsTab from './Components/PushAnnouncementsTab.vue';
import StickersTab from './Components/StickersTab.vue';
import { mapActions, mapState } from 'vuex';
export default {
    components : {
        AccountCategoryTab,
        BusinessTypeTab,
        PushAnnouncementsTab,
        StickersTab
    },
    data : ()=> ({
        componentName : 'account-category',
    }),
	created() {
		this.componentName = this.$route.params.type;
	},
	methods: {
		...mapActions('admin', ['getAll']),
        changePreview(name){
        
            this.$router.push({name : 'admin.configuration.index',params : {type : name}});
            this.componentName = name;
        },
	},
}

</script>