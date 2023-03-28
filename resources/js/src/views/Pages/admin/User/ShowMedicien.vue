<template>
    
<div class="app-content content">
    <div class="content-wrapper">
        <!-- Basic form layout section start -->
        <section id="configuration" class="user-page">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12">
                        <h2>
                            <a @click="$router.go(-1)"><i class="fa fa-chevron-left"></i></a>                           
                            
                            Medicine Details</h2>
                    </div>
                </div>
            </div>
            <div class="content-body bg-white shadow-sm rounded-10 p-4 p-lg-5 medician-detail">
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-xxl-3 mb-3 mb-md-0">
                        <img :src="medicine_data.medicine_picture_url" alt="" class="img-fluid w-100">
                    </div>
                    <div class="col-md-7 col-lg-7 col-xxl-6">
                        <h2 class="text-seegreen mb-4">{{medicine_data.medicine_name}} <span class="text-black">({{medicine_data.potency_volume_medicine}})</span></h2>
                        <h3 class="fw-light mb-2">{{medicine_data.medicine_type}}</h3>
                        <p>{{medicine_data.notes}}</p>
                        <div class="user-meta">
                            <ul class="ps-0">
                                <li class="color-meta fw-light lh-1">Color 
                                      <input class="rounded-circle d-inline-block align-middle" type="color" style="border:none" id="favcolor" name="favcolor" value="#ff0000"><br>
                                    </li>
                                <li class="fw-light">Created by: {{medicine_data.med_creator.first_name}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</template>
<script>
import { mapActions, mapState } from 'vuex';

export default {
    computed: {
    },
    async created() {
        //  this.type = this.$route.params.type; 
        let { page } = this.$route.query;
        await this.fetch(page);
    },
    watch: {
      search: function(val, oldVal) {
      	this.fetch();
      },

    },
    data () {
      return {
        user : {},
        medicine_data:{}
      };
    },
    methods: {
        ...mapActions('admin', ['get']),
         async fetch() {
        	let {id} = this.$route.params;
        
            let params = {
                route: route('admin.users.viewMedicine',{id}),
                // mutation: 'SET_ADMIN',
                // variable: 'admin',
                data: {}
            };
            let { data } = await this.get(params);
             this.medicine_data = data.get_user_medicine;
             console.log(this.medicine_data)
            // let {permissions} = this.form; 
            // this.form = this.admin;
            // this.form.permissions = (this.admin.permissions)?this.admin.permissions:permissions;
        },
    }
}

</script>