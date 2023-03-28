<template>
    <div>
         <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-12 my-3">
                <div class="col-md-9 m-auto">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">
                                User Name :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{detail.username}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Business Name :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{detail.business_name}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">QR Code :</p>
                        </div>
                        <div class="fieldData col-md-6 d-flex flex-wrap gap-15 align-items-center">
                            <p class="mb-0 text-black-50">{{detail.referal_code}}</p>
                            <img :src="`../images/smile.png`" alt="" class="mw-100 w-100px">
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Code :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{detail.code}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Wallet :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">$ {{detail.credits}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">No. of Smiles Earned :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{detail.smiles_balance}}</p>
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
    }),
    async created(){
        await this.fetch();
    },
    methods : {
        ...mapActions('admin',['getAll','get']),
        async fetch(page = 1) {
			let params = {
				route: route('admin.ambassador.show',this.$route.params.id),
				 data: {
                }
			};
			let { data } = await this.get(params);
            this.detail = data.ambassador;
		},
        
    },
}
</script>