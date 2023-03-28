<template>
    <div>
        <div class="report-section shadow p-5 rounded-15 my-4">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-12 my-3">
                    <div class="col-md-9 m-auto">
                        <div class="d-flex mb-3 flex-wrap align-items-center">
                            <div class="labelTitle col-md-6">
                                <p class="mb-0 font-weight-600">Package Name :</p>
                            </div>
                            <div class="fieldData col-md-6 d-flex flex-wrap gap-15 align-items-center">
                                <p class="mb-0 text-black-50">{{detail.package_name}}</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3 flex-wrap align-items-center">
                            <div class="labelTitle col-md-6">
                                <p class="mb-0 font-weight-600">Number of Smiles :</p>
                            </div>
                            <div class="fieldData col-md-6 d-flex flex-wrap gap-15 align-items-center">
                                <p class="mb-0 text-black-50">{{detail.no_of_smiles}}</p>
                                <img src="images/smile.png" alt="" class="mw-100 w-100px">
                            </div>
                        </div>
                        <div class="d-flex mb-3 flex-wrap align-items-center">
                            <div class="labelTitle col-md-6">
                                <p class="mb-0 font-weight-600">No of Boosts :</p>
                            </div>
                            <div class="fieldData col-md-6">
                                <p class="mb-0 text-black-50">{{detail.no_of_boosts}} <strong>Per</strong> {{detail.clicks}} clicks</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3 flex-wrap align-items-center">
                            <div class="labelTitle col-md-6">
                                <p class="mb-0 font-weight-600">Amount :</p>
                            </div>
                            <div class="fieldData col-md-6">
                                <p class="mb-0 text-black-50">$ {{detail.package_amount}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions} from 'vuex';
export default {
    data : ()=> ({
        detail : {},
        purchases : {},
    }),
    async created(){
        await this.fetch();
    },
    methods : {
        ...mapActions('admin',['getAll','get']),
        async fetch(page = 1) {
			let params = {
				route: route('admin.packages.show',{type: 'package',id : this.$route.params.id}),
				 data: {
                }
			};
			let { data } = await this.get(params);
            this.detail = data.package;
		},
        async fetchPurchases(){
            let params = {
				route: route('admin.packages.purchases',{type: 'package'}),
				 data: {
                    page,
                    status: this.currentStatus,
                    search : this.search,
                    entries : this.entries,
                    dateFrom: this.dateFrom,
                    dateTill: this.dateTill,
                }
			};
			let { data } = await this.getAll(params);
            this.purchases = data.purchases;
        }
    },
}
</script>