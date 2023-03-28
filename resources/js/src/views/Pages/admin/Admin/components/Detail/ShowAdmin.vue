<template>
    <div>
        <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-10 m-auto my-3 pt-3">
                
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">First Name:</p>
                        </div>
                        <div class="fieldData col-md-9">
                              {{form.name}}
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Last Name:</p>
                        </div>
                        <div class="fieldData col-md-9">
                           {{form.last_name}}
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Email:</p>
                        </div>
                        <div class="fieldData col-md-9">
                             {{form.email}}
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-3">
                            <p class="mb-0 font-weight-bold">Password:</p>
                        </div>
                        <div class="fieldData col-md-9">
                             ***********
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
       
    }
}

</script>
