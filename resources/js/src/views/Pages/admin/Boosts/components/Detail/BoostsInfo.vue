<template>
    <div>
          <div class="report-section shadow p-5 rounded-15 my-4">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-7 m-auto my-3 pt-3">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Boost Name :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{detail.type}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Business Username :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{detail.business_username}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Amount :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{detail.transaction.amount}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Target :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">02.02.2021</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Time :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{ detail.starting_time | this.$moment("hh:mm a") }}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Date :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{formatDate(detail.starting_date)}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Total Clicks :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{detail.clicks}}</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-600">Remaining Clicks :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <p class="mb-0 text-black-50">{{detail.clicks_left}}</p>
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
				route: route('admin.boost.show',this.$route.params.id),
				 data: {
                }
			};
			let { data } = await this.get(params);
            this.detail = data.boost;
		},
        
    },
}
</script>