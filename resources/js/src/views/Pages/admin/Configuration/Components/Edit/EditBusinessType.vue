<template>
    <div>

       
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                  <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{ name: 'admin.configuration.index' , params:{type:'business-type'} }" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Edit Business Type</router-link></h3>
            </div>
        </div>
    </div>
    <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-7 m-auto my-3 pt-3">
                 <validation-observer v-slot="{handleSubmit}">
                <form @submit.prevent="handleSubmit(update)">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Account Category :</p>
                        </div>
                        <div class="fieldData col-md-6">
                              <validation-provider tag="div" rules="required" name="Account Category" v-slot="{errors}" >
                            <select v-model="form.category_id" class="form-select form-select-sm pr-5 py-2" name="Account Category" aria-label=".form-select-sm example">
                                <option value="">Select Category</option>
                                 <option v-for="accountCategorie in accountCategories" :value="accountCategorie.id" :key="accountCategorie.id">{{ accountCategorie.name }}</option>
                            </select>
                             <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Business Type Name :</p>
                        </div>
                        <div class="fieldData col-md-6">
                             <validation-provider tag="div" rules="required" name="Business Type Name" v-slot="{errors}" >
                            <input type="text" v-model="form.name" placeholder="Business Type Name" name="Business Type Name" class="form-control pr-5 py-2 h-auto">
                             <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Status :</p>
                        </div>
                        <div class="fieldData col-md-6">
                             <validation-provider tag="div" rules="required" name="status" v-slot="{errors}" >
                            <select v-model="form.status" class="form-select form-select-sm pr-5 py-2" aria-label=".form-select-sm example">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                             <div class="text-danger">{{errors[0]}}</div>
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

    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    
    data() {
        return {
            accountCategories:{},
            form: {
                category_id:'',
                name:'',
                status:''
            }
        };
    },
    created()
    {
        this.fetchAccountCategory();
        this.fetch();
    },
    methods: {

        ...mapActions('admin', ['store' ,'getAll']),
        async fetch(page = 1) {
			let params = {
				route: route('admin.configuration.business_type.show',{id: this.$route.params.id}),
				 data: {
                    page
                }
			};
			let { data } = await this.getAll(params);
            this.form = data.business_type;
		},
        async update() {
            let fd = new FormData();
            fd.append('_method','PUT');
            this.buildFormData(fd, this.form);
            let params = {
                route: route('admin.configuration.business_type.update' ,{id: this.$route.params.id}),
                method: 'POST',
                data: fd,
            };
            try {
                let { data } = await this.store(params);
                if (data.status) {
                    this.$snotify.success(data.msg);
                    this.$router.push({ name: 'admin.configuration.index' , params:{type:'business-type'} });
                   
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
        async fetchAccountCategory() {
            let params = {
                route: route('admin.configuration.account_category'),
                data: {
                }
            };
            let { data } = await this.getAll(params);
            console.log(data);
            this.accountCategories = data.account_categories;
        },
        
    }
}

</script>
