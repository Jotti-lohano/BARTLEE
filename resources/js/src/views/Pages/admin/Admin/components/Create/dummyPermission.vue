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
                             <validation-provider tag="div" rules="required" name="Last name" v-slot="{errors}" >
                            <input type="text" placeholder="Enter Last Name" name="Last Name" class="form-control pr-5 py-2 h-auto">
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
                    <div class="d-flex my-4 flex-wrap align-items-center">
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
                                    <input :value="permission.children[0]" class="form-check-input position-relative" type="checkbox">
                                    </td>
                                    <!-- <td>
                                    <input v-model="permission.children.create"  class="form-check-input position-relative" type="checkbox">
                                    </td>
                                    <td>
                                    <input v-model="permission.children.update"  class="form-check-input position-relative" type="checkbox">
                                    </td>
                                    <td>
                                    <input v-model="permission.children.delete"  class="form-check-input position-relative" type="checkbox">
                                    </td> -->
                                </tr>                        
                               
                            </tbody>
                        </table>
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
            permissions:[
                 {
                    module_name : 'Users',
                    identifier : 'users',
                    children : ['admin.users.index' , 'admin.users.create'  , 'admin.users.update' , 'admin.users.delete' ],
                },
                {
                    module_name : 'Businesses',
                    identifier : 'business',
                    children : ['admin.business.index' , 'admin.business.create'  , 'admin.business.update' , 'admin.business.delete' ],
                },

                // {
                //     module_name : 'Reports',
                //     identifier : 'reports',
                //     children : {
                //     'admin.reports.index' : false,
                //     'admin.reports.create' : false,
                //     'admin.reports.edit' : false,
                //     'admin.reports.delete' : false,
                //     },
                // },
                // {
                //     module_name : 'Challanges',
                //     identifier : 'challange',
                //     children : {
                //     'admin.challange.index' : false,
                //     'admin.challange.create' : false,
                //     'admin.challange.edit' : false,
                //     'admin.challange.delete' : false,
                //     },
                // },
                // {
                //     module_name : 'Packages',
                //     identifier : 'packages',
                //     children : {
                //     'admin.packages.index' : false,
                //     'admin.packages.create' : false,
                //     'admin.packages.edit' : false,
                //     'admin.packages.delete' : false,
                //     },
                // },
                // {
                //     module_name : 'Ambassadors',
                //     identifier : 'ambassador',
                //     children : {
                //     'admin.ambassador.index' : false,
                //     'admin.ambassador.create' : false,
                //     'admin.ambassador.edit' : false,
                //     'admin.ambassador.delete' : false,
                //     },
                // }
                // ,
                // {
                //     module_name : 'Offers',
                //     identifier : 'offer',
                //     children : {
                //     'admin.offer.index' : false,
                //     'admin.offer.create' : false,
                //     'admin.offer.edit' : false,
                //     'admin.offer.delete' : false,
                //     },
                // },
                // {
                //     module_name : 'Events',
                //     identifier : 'event',
                //     children : {
                //     'admin.event.index' : false,
                //     'admin.event.create' : false,
                //     'admin.event.edit' : false,
                //     'admin.event.delete' : false,
                //     },
                // },
                // {
                //     module_name : 'Boosts',
                //     identifier : 'boosts',
                //     children : {
                //     'admin.boosts.index' : false,
                //     'admin.boosts.create' : false,
                //     'admin.boosts.edit' : false,
                //     'admin.boosts.delete' : false,
                //     },
                // }
                ],
            form: {
                permissions: [],
            }
        };
    },
    methods: {
        ...mapActions('admin', ['store']),
        async create() {

            
            let fd = new FormData();
            this.buildFormData(fd, this.form);
            let params = {
                route: route('admin.admin.store'),
                method: 'POST',
                data: fd,
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
