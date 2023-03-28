<template>
    <div>
        
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{ name: 'admin.configuration.index' , params:{type:'stickers'} }" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i> Stickers</router-link></h3>
   
            </div>
        </div>
    </div>
    <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-7 m-auto my-3 pt-3">
    
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Sticker Name :</p>
                        </div>
                        <div class="fieldData col-md-6">
                             {{form.name}}
                           
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Status :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            {{form.status_detail}}
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Sticker Image :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            
                             <img width="300" height="300" :src="`storage/${form.image}`">
                        </div>
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
            form: {
                img:'',
                name:'',
                image:'',
                status:''
            }
        };
    },
    created(){
        this.fetch();
    },
    methods: {
        ...mapActions('admin', ['store' ,'getAll']),
        async fetch(page = 1) {
			let params = {
				route: route('admin.configuration.stickers.show',{id: this.$route.params.id}),
				 data: {
                    page
                }
			};
			let { data } = await this.getAll(params);
            this.form = data.sticker;
		},
       
        
    }
}

</script>
