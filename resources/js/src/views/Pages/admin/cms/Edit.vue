<template>
<div class="addPackages">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold">Update Page</h3>
            </div>
        </div>
    </div>
    <div class="row shadow p-5 rounded-15 my-3">
        <validation-observer tag="div" v-slot="{handleSubmit}" class="col-12">
            <form @submit.prevent="handleSubmit(update)">
                <validation-provider tag="div" rules="required" name="page name" v-slot="{errors}" class="form-group row align-items-baseline">
                    <label for="smiles" class="col-lg-4 col-form-label font-weight-bold">Page Name:</label>
                    <div class="col-lg-8">
                    <div class="d-flex align-items-baseline">
                        <input v-model="form.name" type="text" class="form-control border-0 shadow" id="smiles" value="" placeholder="Page Name">
                    </div>
                    <span class ="text-danger">{{errors[0]}}</span>
                    </div>
                </validation-provider>
                <validation-provider tag="div" rules="required" name="page content" v-slot="{errors}" class="form-group row align-items-baseline">
                    <label for="amount" class="col-lg-4 col-form-label font-weight-bold">Content:</label>
                    <div class="col-lg-8">
                        <quill-editor v-model="form.content" ></quill-editor>
                        <!-- <input v-model="form.content" type="number" class="form-control border-0 shadow" id="amount" value="" placeholder="Enter Amount"> -->
                        <span class ="text-danger">{{errors[0]}}</span>
                    </div>
                </validation-provider>
                <div class="text-center mt-4">
                    <button type="submit" class="btn bg-theme-primary text-white py-2 px-5">Update</button>
                </div>
            </form>
        </validation-observer>
    </div>    
</div>
</template>
<script>
import { mapActions } from 'vuex'
export default {
    data : ()=> ({
        form : {},
    }),
    async mounted(){
        await this.fetch();
    },
    methods : {
        ...mapActions('admin',['store','get']),
        async fetch(){
            let {data} = await this.get({
                route : route('admin.pages.show',{page : this.$route.params.id}),
            });

            this.form = data.page;
        },
        async update(){
            let fd = new FormData();
            this.buildFormData(fd,this.form);
            fd.append('_method','PUT')
            try {
                let {data} = await this.store({
                    route : route('admin.pages.update',{page : this.$route.params.id}),
                    method : 'post',
                    data : fd,
                });
                if(data.status){
                    this.$snotify.success(data.message);
                    this.$router.push({name : 'admin.cms.index'});
                }
            } catch (error) {
                console.error(error);
            }
        },
    },
}
</script>