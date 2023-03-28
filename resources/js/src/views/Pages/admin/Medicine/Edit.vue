<template>
<div class="app-content content">
    <div class="content-wrapper">
        <!-- Basic form layout section start -->
        <section id="medicine_manage" class="medicine-manage-edit-page">
            <div class="page-title mb-4">
                <div class="row">
                    <div class="col-12">
                        <h2>

                            <router-link :to="{name : 'admin.medicine.index'}">
                             <i class="fas fa-chevron-left"></i>
                            </router-link>
                            
                            Medicine Type Management</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="content-body bg-white rounded-10 shadow-sm p-4 p-lg-5">
                        <div class="dataTables_wrapper">
                            <div class="user-listing-top">
                                 <div class="user-listing-top">
                                <div class="row align-items-end d-flex mb-3">
                                    <div class="col-12 col-md-7 col-lg-7 col-xxl-4 mb-2 mb-md-0">
                                        <div class="page-title">
                                            <h3 class="fw-medium mb-3 mb-lg-5">Edit Medicine Type</h3>
                                        </div>
                              
                                    </div>
                                </div>

                            </div>
                             

                            </div>
                              <ValidationObserver v-slot="{handleSubmit}">
                                <form @submit.prevent="handleSubmit(update)">
                            <div class="main-tabble table-responsive mx-n2">
                                <table class="table table-borderless dataTable px-2">
                                    <thead>
                                        <tr>
                                            <th class="sorting">Sr. No.</th>
                                            <th class="sorting">Medicine Type</th>
                                            <th class="sorting">Potency/Volume</th>
                                            <th class="sorting">Status</th>
                                            <th class="sorting">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        <tr v-for="(med,index) in medicine.data" :key="index">
                                            <td>{{++index}}</td>
                                            <td v-if="active_id == med.id"><input type="text" v-model="form.medicine_type" maxlength="15" class="form-control" ></td>
                                            <td v-else>{{med.medicine_type}}</td>
                                            <td v-if="active_id == med.id"><input type="text" v-model="form.volume" maxlength="15" class="form-control" ></td>
                                            <td v-else>{{med.volume}}</td>
                                            <td>{{med.status == '1' ? 'Active' : 'Expire'}}</td>
                                            <td v-if="active_id == med.id">
                                                <button  type="submit" data-bs-toggle="modal" data-bs-target=".medicine-updated" class="btn btn-blue">Update</button>
                                            </td>
                                            <td v-else>
                                             <div class="btn-group ml-1">
                                                <button type="button" class="btn dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a v-if="med.status == 0" class="dropdown-item" @click="changeStatusPopUp(med, 'active')" data-toggle="modal" data-target=""><i class="fa fa-ban"></i>Active</a>
                                                    <a v-else class="dropdown-item mb-1" @click="changeStatusPopUp(med, 'inactive')" data-toggle="modal" data-target=""><i class="fa fa-ban"></i>Inactive</a>
                                                    <router-link class="dropdown-item" :to="{name : 'admin.medicine.edit',params : {id : med.id,} }"><i class="fa fa-edit"></i>Edit</router-link>
                                                </div>
                                            </div>
                                            </td>                                       
                                        </tr>  
                                       

                                    </tbody>
                                </table>
                            </div>
                             </form>
                        </ValidationObserver>
                            <div class="row mt-3">
                                <div class="col-sm-12 col-xxl-5 align-self-center text-center text-xxl-start">
                            <div class="dataTables_info pl-2"> Showing {{medicine.to}} of {{medicine.total}} entries</div>
                                </div>
                                <div class="col-sm-12 col-xxl-7 d-flex justify-content-center justify-content-xxl-end">
                                    <div class="dataTables_paginate">
                                        <ul class="pagination">
                           <pagination :data="medicine" @pagination-change-page="fetch"></pagination>                   

                                        </ul>
                                    </div>
                                </div>
                            </div>
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
    components: {
    },
    data() {
        return {
            medicine : {},
            form:{
                medicine_type:'',
                volume: '',
            }, 
            type : '',
            entries : 10,
            search : null,
            popupMsg: '',
            updatingStatus: "",
            confirmation_popupMsg: "",
            active_id : this.$route.params.id,
            edit_data:[]
        };
    },
    created() {
        
        let { page } = this.$route.query;
        this.fetch(page);
    },
    watch: {
        search: function(val, oldVal) {
            this.fetch();
        },
        entries: function(val, oldVal) {
            this.fetch();
        },
        type: function(val, oldVal) {
            this.fetch();
        },

    },
    methods: {
        ...mapActions('admin', ['getAll','store','manageStatusMed']),
        async fetch(page = 1) {
            let { type, status } = this.$route.params;
            let params = {
                route: route('admin.users.medicine'),
                data: {
                    page,
                    type,
                    status: this.currentStatus,
                    search : this.search,
                    entries : this.entries,
                    type : this.type,
                }
            };

            let { data } = await this.getAll(params);
            this.medicine = data.medicine;

            var edit_data = this.medicine.data[this.$route.params.id - 1];
            this.form.medicine_type = edit_data.medicine_type;
            this.form.volume = edit_data.volume;
           
        },
           async create(){
            try {
                let fd = new FormData();
                this.buildFormData(fd,this.form);
                let {data} = await this.store({
                    route : route('admin.users.medicine'),
                    method: 'POST',
                    data: fd,
                });
                if(data.status){
                    this.$snotify.success(data.msg);
                    
                     this.form.medicine_type = '';
                     this.form.medicine_volume='';
                     this.fetch();
                }
            } catch (error) {
                let {errors,msg} = error.response.data 
                if(error.status != 200){
                    this.errorMessage = 'something went wrong';
                }
            }
        },
         async update() {
            let fd = new FormData();
            fd.append('_method', 'POST');
            this.buildFormData(fd,this.form);
            let params = {
                route: route('admin.users.medicine.edit',{id: this.$route.params.id}),
                method: 'POST',
                data: fd,
            };
            let {data} = await this.store(params);
            this.$snotify.success(data.msg);
            this.$router.push({name: 'admin.medicine.index'});
        },
        fetchFilteredData(e){
            this.currentStatus = e.target.value;
            this.fetch();
        },

        clearCalandar(){
            this.dateFrom = '';
            this.dateTill = '';
            this.fetch();
        },
            changeStatusPopUp(user, status){
            $('#activate-user-modal').modal('show');

            if(status == 'inactive'){
                this.popupMsg =  'Are you sure you want to mark as In-Active?';
                this.updatingStatus = "0";
            }else{
                this.popupMsg = 'Are you sure you want to mark as Active?';
                this.updatingStatus = "1";
            }
            this.editUser = {};
            this.editUser = user;
        },
          async changeStatus(){

            let users = this.editUser;
            let { data } = await this.manageStatusMed({userId: users.id, status: this.updatingStatus});
            if(data.status){
                 this.fetch();
                var index = await _.findIndex(this.users.data, function(o) { return o.id == users.id; });
                this.users.data[index]['status'] = data.status;
            }
            if(this.updatingStatus == "1"){
                this.confirmation_popupMsg = 'Active Successfully!';
            }else{
                this.confirmation_popupMsg = 'Inactive Successfully!';
            }
            $('#activated-user-modal').modal('show');
            setTimeout(()=>{
                $('#activated-user-modal').modal('hide');
            }, 1500);
        },
    }
}

</script>