<template>
    <div>
         <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-9 m-auto my-3 pt-3">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Promo Code Name :</p>
                        </div>
                        <div class="fieldData col-md-9">
                             {{form.name}}
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Details :</p>
                        </div>
                        <div class="fieldData col-md-9">
                          {{form.detail}}
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Promo For :</p>
                        </div>
                        <div class="fieldData col-md-9 d-flex flex-wrap" v-if="form.promo_for != ''">
                         
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.promo_for.registration =='true'">
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">Registration :</p>
                                </div>
                                <div class="fieldData col-md-8">
                                    {{form.registration_percent}}
                                </div>
                            </div>
                            
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.promo_for.smiles =='true'">
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">No. of Smiles :</p>
                                </div>
                                <div class="fieldData col-md-8">
                                      {{form.no_of_smiles}}
                                </div>
                            </div>
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.promo_for.boosts =='true'">
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">Boosts (No. of Clicks) :</p>
                                </div>
                                <div class="fieldData col-md-8">
                                    {{form.boosts_no_of_clicks}}
                                </div>
                            </div>
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.promo_for.reports =='true'">
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">No. of Reports :</p>
                                </div>
                                <div class="fieldData col-md-8">
                                    {{form.no_of_report}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Promo Code :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <p class="mb-0"><span class="theme-primary-text" >{{form.promo_code}}</span> 
                                
                            
                            </p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Start Date :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <div class="form-group">
                                {{form.starting_date}}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Ending Date :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <div class="form-group">
                                {{form.expiry_date}}
                            </div>
                        </div>
                    </div>
                
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Buisness Type :</p>
                        </div>
                        <div class="fieldData" >
                             {{form.business_types.map(({name}) => name).join(', ')}}
                        </div>
                        
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Buisness Name :</p>
                        </div>
                        <div class="fieldData" >
                                {{form.business_names.map(({business_name}) => business_name).join(', ')}}
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap  my-3">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Code Usability:</p>
                        </div>
                        <div class="fieldData col-md-9 d-flex flex-wrap">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                        
                                    <label class="form-check-label" for="once">{{form.code_usability}}</label>
                                </div>
                                
                            </div>
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.code_usability == 'multiple'">
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">No. of  Times :</p>
                                </div>
                                <div class="fieldData col-md-8">
                                            {{form.code_usability_no_of_times}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Status :</p>
                        </div>
                        <div class="fieldData col-md-9">
                          {{form.status_detail}}
                        </div>
                    </div>
                   
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    data() {
        return {
            permissions:[
                {
                    module_name : 'Users',
                    identifier : 'user',
                    children : {
                    'view' : false,
                    'create' : false,
                    'update' : false,
                    'delete' : false,
                    },
                },
                ],
            form: {
            }
        };
    },
     computed: {
        ...mapState('admin', ['promotional']),
    },
     created() {
        this.fetch();
    },
    methods: {
        ...mapActions('admin', ['store' ,'get']),
         async fetch() {
        	let {id} = this.$route.params;
        
            let params = {
                route: route('admin.promotionals.show',{id}),
                mutation: 'SET_PROMOTIONAL',
                variable: 'promotional',
                data: {}
            };
            let { data } = await this.get(params);
            
            this.form = this.promotional;
        },
       
    }
}

</script>
