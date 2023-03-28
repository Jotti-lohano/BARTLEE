<template>
    <div>
        
<div class="userSection">
    <div class="row">
        <div class="col-md-12">
            <div class="titleBox py-4">
                  <h3 class="mb-0 achivpFont mb-0 font-weight-bold"><router-link :to="{ name: 'admin.configuration.index' , params:{type:'push-announcements'} }" class="text-dark text-decoration-none"><i class="bi bi-chevron-left"></i>Add Push Announcement</router-link></h3>
            </div>
        </div>
    </div>
    <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-7 m-auto my-3 pt-3">
                 <validation-observer v-slot="{handleSubmit}">
                <form @submit.prevent="handleSubmit(create)">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Announcement Name :</p>
                        </div>
                        <div class="fieldData col-md-6">
                             <validation-provider tag="div" rules="required" name="announcement" v-slot="{errors}" >
                             <input type="text" v-model="form.title" placeholder="Enter Announcement Name" name="announcement" class="form-control pr-5 py-2 h-auto">
                             <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>
                           
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Description :</p>
                        </div>
                        <div class="fieldData col-md-6">
                             <validation-provider tag="div" rules="required" name="description" v-slot="{errors}" >
                             <textarea size="100" rows="4" cols="50" v-model="form.description" placeholder="Enter Announcement Name" name="announcement" class="form-control pr-5 py-2 h-auto"></textarea>
                             <div class="text-danger">{{errors[0]}}</div>
                            </validation-provider>
                        </div>
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

    </div>
</template>


<script>
import { mapActions, mapState } from 'vuex';
export default {
    
    data() {
        return {
            form: {
                title:'',
                description:''
            }
        };
    },
    methods: {
        ...mapActions('admin', ['store']),
        async create() {
            let fd = new FormData();
            this.buildFormData(fd, this.form);
            let params = {
                route: route('admin.configuration.announcements.store'),
                method: 'POST',
                data: fd,
            };
            try {
                let { data } = await this.store(params);
                if (data.status) {
                    this.$snotify.success(data.msg);
                    this.$router.push({ name: 'admin.configuration.index' , params:{type:'push-announcements'} });
                   
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
        onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                // let vm = this;
                reader.onload = (e) => {
                    this.form.img = e.target.result;
                };
                reader.readAsDataURL(file);
                this.form.image  = file;
            },
        
    }
}

</script>
