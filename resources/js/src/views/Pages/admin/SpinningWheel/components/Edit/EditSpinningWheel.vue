<template>
    <div>
     <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-7 m-auto my-3 pt-3">
                 <validation-observer v-slot="{handleSubmit}" class="col-12">
                <form @submit.prevent="handleSubmit(update)">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Reward Name :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <validation-provider tag="div" rules="required" v-slot="{errors}" >
                             <input type="text" v-model="form.reward_name" placeholder="Reward Name" name="Reward Name" class="form-control pr-5 py-2 h-auto">
                            <span class="text-danger">{{errors[0]}}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Reward :</p>
                        </div>
                        <div class="fieldData col-md-6">
                             <validation-provider tag="div" rules="required" v-slot="{errors}" >
                            <input type="number" v-model="form.reward" placeholder="Reward" name="Reward" class="form-control pr-5 py-2 h-auto">
                             <span class="text-danger">{{errors[0]}}</span>
                            </validation-provider>
                        </div>
                    </div>
                     <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Type :</p>
                        </div>
                        <div class="fieldData col-md-6">
                             <validation-provider tag="div" rules="required" v-slot="{errors}" >
                            <select v-model="form.type"  id="Type" class="form-select form-select-sm pr-5 py-2" aria-label=".form-select-sm example">
                                <option value="" selected>Select Reward Type</option>
                                <option value="smile">Smiles</option>
                                
                            </select>
                             <span class="text-danger">{{errors[0]}}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="submitBtn text-center pt-5">
                        <input type="submit" value="Update" class="submitStyle border-0 rounded-15 px-5">
                    </div>
                </form>
                 </validation-observer>
            </div>
        </div>
    </div>
    </div>
</template>



<script>
import {mapActions , mapMutations} from 'vuex';
export default {
    data : ()=> ({
        form : {reward_name:'' ,reward:'' , type:''},
    }),
     created() {
        this.fetch();
    },
    
    methods : {
         ...mapActions('admin', ['store' ,'get']),
        async fetch() {
			let params = {
				route: route('admin.reward.show',this.$route.params.id),
				 data: {
                }
			};
			let { data } = await this.get(params);
            this.form = data.reward;
		},


         async update() {
         try {
            let params = {
                 route: route('admin.reward.update' ,this.$route.params.id),
                    method: 'PUT',
                // mutation: 'SET_USERS',
                // variable: 'users',
                data: {
                    reward_name : this.form.reward_name,
                    type : this.form.type,
                    reward : this.form.reward
                }
            };
            let { data } = await this.store(params);
            // console.log(data ,"<<<<<<<<");
             this.$snotify.success(data.msg)
                    let self = this;
                    setTimeout(function() {
                      
                        self.$router.push({ name: 'admin.wheel.index' });
                    }, 2000);
            }
            catch(e){
                 if (e.response) {
                    this.response = e.response.data
                }
                console.log(e);
            }
            /* if (page != 1) {
                this.addRouteQuery({ page });
            } else {

                this.addRouteQuery({});
            } */
        },
    },
}
</script>