<template>
     <validation-observer tag="div" v-slot="{handleSubmit}" class="col-12">
            <form @submit.prevent="handleSubmit(create)">
                <validation-provider tag="div" rules="required" name="number of smiles" v-slot="{errors}" class="form-group row align-items-baseline">
                    <label for="smiles" class="col-lg-4 col-form-label font-weight-bold">Number of Smiles:</label>
                    <div class="col-lg-8">
                    <div class="d-flex align-items-baseline">
                        <input v-model="form.number_of_smiles" type="number" class="form-control border-0 shadow" id="smiles" value="" placeholder="Enter Number of Smiles">
                        <span class="mx-1">&#128515;</span>
                    </div>
                    <span class ="text-danger">{{errors[0]}}</span>
                    </div>
                </validation-provider>
                <validation-provider tag="div" rules="required" name="amount" v-slot="{errors}" class="form-group row align-items-baseline">
                    <label for="amount" class="col-lg-4 col-form-label font-weight-bold">Amount:</label>
                    <div class="col-lg-8">
                        <input v-model="form.amount" type="text" class="form-control border-0 shadow" id="amount" value="" placeholder="Enter Amount">
                        <span class ="text-danger">{{errors[0]}}</span>
                    </div>
                </validation-provider>
                <div class="text-center mt-4">
                    <button type="submit" class="btn bg-theme-primary text-white py-2 px-5">Update</button>
                </div>
            </form>
        </validation-observer>
</template>
<script>
import {mapActions} from 'vuex';
export default {
    data : ()=> ({
        form : {},
        errorMessage : null,
    }),
    async created(){
        await this.fetch();
    },
    methods : {
        ...mapActions('admin',['store','get']),
        async fetch(page = 1) {
			let params = {
				route: route('admin.packages.show',{type: 'smile',id : this.$route.params.id}),
				 data: {
                }
			};
			let { data } = await this.get(params);
            this.form = data.smile;
		},
        async create(){
            try {
                let fd = new FormData();
                this.buildFormData(fd,this.form);
                fd.append('_method','PUT');
                let {data} = await this.store({
                    route : route('admin.packages.update',{type : 'smile',id : this.$route.params.id}),
                    method: 'POST',
                    data: fd,
                });
                if(data.status){
                    this.$snotify.success(data.msg);
                    this.$router.push({ name: 'admin.packages.index',params : {type : 'smiles'} });
                }
            } catch (error) {
                let {errors,msg} = error.response.data 
                if(error.status != 200){
                    this.errorMessage = 'something went wrong';
                }
            }
        },
    },
}
</script>