<template>
    <div>
        <div class="tab-pane fade show active" id="business" role="tabpanel" aria-labelledby="business-tab">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Registration:</h3>
            </div>
            <div class="notification-section shadow p-5 rounded-15 my-4">
                <div class="row">
                    <div class="col-md-12 pt-5 table-responsive">
                          <Table @page-changed="fetch" :fields="tableFields" :data="registrations">
                    <table-search 
                
                        show-date-ranges
                        @on-search="setCallback('search',$event,fetch)"
                        @on-change-entries="setCallback('entries',$event,fetch)"
                        @on-change-status="setCallback('currentStatus',$event,fetch)"
                        @on-change-date-from="setCallback('dateFrom',$event,fetch)"
                        @on-change-date-to="setCallback('dateTill',$event,fetch)"
                    /></Table>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import {mapActions} from 'vuex';
export default {
    computed : {
        tableFields(){
            return [{
                key : 'business_name',
                label : 'Business Name',
            },
            {
                label : 'Registered On',
                key : 'created_at',
                format : this.formatDate,
            },{
                label : 'Amount',
                key : 'total',
                format : (amount)=>{  return `$${amount || 0 }` },
            }];
        },
    },
    data: ()=> ({
        registrations : {},
        currentStatus : '',
        search : '',
        entries : '',
        dateFrom : '',
        dateTill : '',
    }),
    async created(){
        await this.fetch();
    },
    methods : {
        ...mapActions('admin',['getAll']),
        async fetch(page = 1) {
			let params = {
				route: route('admin.finance.registration.index',{type: 'package'}),
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
            this.registrations = data.registrations;
		},
    },
}
</script>