<template>
    <div>
         <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-9 m-auto my-3 pt-3">
                <validation-observer v-slot="{handleSubmit}">
                <form @submit.prevent="handleSubmit(create)">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Promo Code Name :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <validation-provider tag="div" rules="required" name="name" v-slot="{errors}" >
                            <input type="text" v-model="form.name" placeholder="Enter Promo Code" name="name" class="form-control pr-5 py-2 h-auto">
                            <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Details :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <validation-provider tag="div" rules="required" name="detail" v-slot="{errors}" >
                            <input type="text"  v-model="form.detail" placeholder="Enter Details" name="detail" class="form-control pr-5 py-2 h-auto">
                             <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Promo For :</p>
                        </div>
                        <div class="fieldData col-md-9 d-flex flex-wrap">
                            <div class="col-md-12 my-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"   v-model="form.promo.registration" type="checkbox" id="registration" value="option1">
                                    <label class="form-check-label" for="registration">Registration</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input  v-model="form.promo.boosts"  class="form-check-input" type="checkbox" id="boosts" value="option2">
                                    <label class="form-check-label" for="boosts">Boosts</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input  v-model="form.promo.smiles"  class="form-check-input" type="checkbox" id="smiles" value="option1">
                                    <label class="form-check-label" for="smiles">Smiles</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input  v-model="form.promo.reports"  class="form-check-input" type="checkbox" id="reports" value="option2">
                                    <label class="form-check-label" for="reports">Reports</label>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.promo.registration" >
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">Registration :</p>
                                </div>
                                <div class="fieldData col-md-8"  >
                                     <validation-provider tag="div" rules="required|numeric" name="registration" v-slot="{errors}" >
                                    <input type="number" v-model="form.registration_percent"  placeholder="Enter Registration" name="registration" class="form-control pr-5 py-2 h-auto">
                                    <div class="text-danger">{{errors[0]}}</div>
                                     </validation-provider>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.promo.smiles" >
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">No. of Smiles :</p>
                                </div>
                                <div class="fieldData col-md-8"  >
                                       <validation-provider tag="div" rules="required|numeric" name="smiles" v-slot="{errors}" >
                                    <input type="number" v-model="form.no_of_smiles"  placeholder="No. of Smiles" name="smiles" class="form-control pr-5 py-2 h-auto">
                                     <div class="text-danger">{{errors[0]}}</div>
                                     </validation-provider>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.promo.boosts" >
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">Boosts (No. of Clicks) :</p>
                                </div>
                                <div class="fieldData col-md-8">
                                    <validation-provider tag="div" rules="required|numeric" name="clicks" v-slot="{errors}" >
                                    <input type="number" v-model="form.boosts_no_of_clicks"  placeholder="No. of Clicks" name="clicks" class="form-control pr-5 py-2 h-auto">
                                      <div class="text-danger">{{errors[0]}}</div>
                                     </validation-provider>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.promo.reports" >
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">No. of Reports :</p>
                                </div>
                                <div class="fieldData col-md-8">
                                    <validation-provider tag="div" rules="required|numeric" name="reports" v-slot="{errors}" >
                                    <input type="number" v-model="form.no_of_report"  placeholder="No. of Reports" name="reports" class="form-control pr-5 py-2 h-auto">
                                     <div class="text-danger">{{errors[0]}}</div>
                                     </validation-provider>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Promo Code :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <p class="mb-0"><span class="theme-primary-text" v-if="!form.isPromo" @click="PromoCode()">Generate</span> <span class="theme-primary-text" @click="PromoCode()">{{form.promo_code}}</span>
                                 <validation-provider tag="div" rules="required" name="Generate Code" v-slot="{errors}" >
                                
                                    <input type="hidden"  v-model="form.promo_code" name="Generate Code">
                                
                                <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>
                            
                            </p>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Start Date :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <div class="form-group">
                                <validation-provider tag="div" rules="required" name="Starting Date" v-slot="{errors}" >
                                <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                                    <input type="date"  v-model="form.starting_date" name="Starting Date"  class="form-control datetimepicker-input" data-target="#datetimepicker8">
                                </div>
                                <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Ending Date :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <div class="form-group">
                                 <validation-provider tag="div" rules="required" name="Expiry Date" v-slot="{errors}" >
                                <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                                    <input type="date" v-model="form.expiry_date" name="Expiry Date"  class="form-control datetimepicker-input" data-target="#datetimepicker8">
                                </div>
                                  <div class="text-danger">{{errors[0]}}</div>
                                  </validation-provider>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Buisness Type :</p>
                        </div>
                        <div class="fieldData col-md-9">
                             <validation-provider name="businessestype" tag="div" rules="required" v-slot="{errors}">
                            <v-select :options="businessesType" id="businessestype" v-model="form.selectedBusinessesType" multiple label="name"></v-select>
                            <span class="text-danger">{{errors[0]}}</span>
                        </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Buisness Name :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <validation-provider name="businesses" tag="div" rules="required" v-slot="{errors}">
                            <v-select :options="businesses"  id="businesses"  v-model="form.selectedBusinesses" multiple label="business_name"></v-select>
                            <span class="text-danger">{{errors[0]}}</span>
                        </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap  my-3">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Code Usability:</p>
                        </div>
                        <div class="fieldData col-md-9 d-flex flex-wrap">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <input  v-model="form.code_usability"  class="form-check-input" type="radio" id="once" value="once">
                                    <label class="form-check-label" for="once">Once</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input  v-model="form.code_usability"  class="form-check-input" type="radio" id="multiple" value="multiple">
                                    <label class="form-check-label" for="multiple">Multiple</label>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap my-3 w-100" v-if="form.code_usability == 'multiple'">
                                <div class="labelTitle col-md-4">
                                    <p class="mb-0 font-weight-bold">No. of  Times :</p>
                                </div>
                                <div class="fieldData col-md-8">
                                     <validation-provider tag="div" rules="required" name="No Of Times" v-slot="{errors}" >
                                    <input type="text" v-model="form.code_usability_no_of_times" placeholder="No. of  Times"  name="No Of Times"  class="form-control pr-5 py-2 h-auto">
                                     <div class="text-danger">{{errors[0]}}</div>
                                    </validation-provider>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Status :</p>
                        </div>
                        <div class="fieldData col-md-9">
                            <validation-provider tag="div" rules="required" name="Status" v-slot="{errors}" >
                            <select  v-model="form.status"  name="Status" class="form-select form-select-sm pr-5 py-2" aria-label=".form-select-sm example">
                                <option selected value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                             <div class="text-danger">{{errors[0]}}</div>
                                    </validation-provider>
                        </div>
                    </div>
                    <div class="submitBtn text-center pt-5">
                        <input type="submit" value="ADD" class="submitStyle border-0 rounded-15 px-5">
                    </div>
                </form>
                </validation-observer>
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
             businessesType:[],
                businesses : [],
            form: {
                promo:{},
                promo_code:'',
                code_usability:'once',
                isPromo:false,
                status:'',
                selectedBusinessesType:[],
                selectedBusinesses : [],
            }
        };
    },
       created() {
        
        this.fetchBusinessTypes();
        this.fetchBusinesses();
    },
    methods: {
        ...mapActions('admin', ['store' ,'getAll' ,'get']),
        async create() {

            
            let fd = new FormData();
            this.buildFormData(fd, this.form);
        
            let params = {
                route: route('admin.promotionals.store'),
                method: 'POST',
                data: fd,
            };
            try {
                let { data } = await this.store(params);
                if (data.status) {
                    this.$snotify.success(data.msg);
                    this.$router.push({ name: 'admin.promos.index' });
                    this.form = {
                        permissions: [],
                    };
                } else {
                    this.$snotify.error('something went wrong');
                }
            } catch (e) {
                if (e.response) {
                    this.$refs.adminObserver.setErrors(e.response.data.errors);
                }
                // statements
                console.log(e);
            }

        },
        async fetchBusinessTypes() {
            let params = {
                route: route('admin.users.businiss_type'),
                data: {
                }
            };
            let { data } = await this.getAll(params);
            this.businessesType = data.business_type;

        },
         async fetchBusinesses(){
            // await 
            let {data} = await this.get({
                route : route('admin.users.businesses',{id : this.$route.params.id}),
                method : 'get',
            });
            this.businesses = data.users;
            
        },

        PromoCode()
        {
            this.form.promo_code = this.CodeGenerator(5);
           this.form.isPromo = true;
        }

         
    }
}

</script>
