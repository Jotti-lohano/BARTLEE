<template>
    <div>
        <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-10 m-auto my-3 pt-3">
                 <validation-observer v-slot="{handleSubmit}">
                <form @submit.prevent="handleSubmit(create)">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">First Name:</p>
                        </div>
                        <div class="fieldData col-md-9">
                              <validation-provider tag="div" rules="required" name="First name" v-slot="{errors}" >
                            <input type="text" v-model="form.name" placeholder="Enter First Name" name="Name" class="form-control pr-5 py-2 h-auto">
                              <div class="text-danger">{{errors[0]}}</div>
                              </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Last Name:</p>
                        </div>
                        <div class="fieldData col-md-9">
                             <validation-provider tag="div" rules="required" name="Last Name" v-slot="{errors}" >
                            <input type="text" v-model="form.last_name" placeholder="Enter Last Name" name="Last Name" class="form-control pr-5 py-2 h-auto">
                            <div class="text-danger">{{errors[0]}}</div>
                              </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Email:</p>
                        </div>
                        <div class="fieldData col-md-9">
                             <validation-provider tag="div" rules="required|email" name="email" v-slot="{errors}" >
                            <input type="text" v-model="form.email" placeholder="Enter Email" name="email" class="form-control pr-5 py-2 h-auto">
                               <div class="text-danger">{{errors[0]}}</div>
                              </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Password:</p>
                        </div>
                        <div class="fieldData col-md-9">
                              <validation-provider tag="div" rules="required" name="Password" v-slot="{errors}" >
                            <input type="password" v-model="form.password" placeholder="Enter Password" name="Password" class="form-control pr-5 py-2 h-auto">
                             <div class="text-danger">{{errors[0]}}</div>
                              </validation-provider>
                        </div>
                    </div>
                    <!-- <div class="d-flex my-4 flex-wrap align-items-center">
                        <div class="labelTitle col-md-12">
                            <p class="mb-0 font-weight-bold">Privilages:</p>
                        </div>
                    </div>
                    <div class="table-reposnive">
                        <table id="userCheckbox" class="w-100 border p-2 text-center">
                            <thead>
                                <th>Modules</th>
                                <th>View</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                
                                  <tr v-for="(permission ,index) in permissions" :key="index">
                                    <td>{{permission.module_name}}</td>
                                    <td>
                                    <input  v-model="permission.children.view" class="form-check-input position-relative" type="checkbox">
                                    </td>
                                    <td>
                                    <input v-model="permission.children.create"  class="form-check-input position-relative" type="checkbox">
                                    </td>
                                    <td>
                                    <input v-model="permission.children.update"  class="form-check-input position-relative" type="checkbox">
                                    </td>
                                    <td>
                                    <input v-model="permission.children.delete"  class="form-check-input position-relative" type="checkbox">
                                    </td>
                                </tr>                        
                               
                            </tbody>
                        </table>
                    </div> -->
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
                permissions: [],
            }
        };
    },
     computed: {
        ...mapState('admin', ['admin']),
    },
     created() {
        this.fetch();
    },
    methods: {
        ...mapActions('admin', ['store' ,'get']),
         async fetch() {
        	let {id} = this.$route.params;
        
            let params = {
                route: route('admin.admin.show',{id}),
                mutation: 'SET_ADMIN',
                variable: 'admin',
                data: {}
            };
            let { data } = await this.get(params);
            let {permissions} = this.form; 
            this.form = this.admin;
            this.form.permissions = (this.admin.permissions)?this.admin.permissions:permissions;
        },
        async create() {

            
            let fd = new FormData();
            this.buildFormData(fd, this.form);
            let {id} = this.$route.params;
            let params = {
                route: route('admin.admin.update',{id}),
                method: 'PUT',
                data: {
                    name:this.form.name,
                    last_name:this.form.last_name,
                    email:this.form.email,
                    password:this.form.password,
                },
            };
            try {
                let { data } = await this.store(params);
                if (data.status) {
                    this.$snotify.success(data.msg);
                    this.$router.push({ name: 'admin.admins.index' });
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

        }
    }
}

</script>
