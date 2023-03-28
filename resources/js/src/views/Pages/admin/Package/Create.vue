<!-- <template>
  <div class="app-content content">
    <div class="content-wrapper"> -->
      <!-- Basic form layout section start -->
      <!-- <section
        id="subscription_plans_edit_manage"
        class="subscription-plans-edit-page"
      >
        <div class="page-title mb-4">
          <div class="row">
            <div class="col-12">
              <h2>
                <router-link :to="{ name: 'admin.packages.index' }">
                  <i class="fas fa-chevron-left"></i>
                </router-link>

                Add Subscription Plan
              </h2>
            </div>
          </div>
        </div>
        <div class="content-body bg-white rounded-10 shadow-none p-4 p-lg-5">
          <div class="row">
            <ValidationObserver v-slot="{ handleSubmit }">
              <form @submit.prevent="handleSubmit(update)">
                <div class="col-md-6 col-lg-6 col-xxl-4">
                  <div
                    class="card subscriber-card subscriber-card-edit rounded-10"
                  >
                    <div
                      class="
                        card-header
                        px-4
                        bg-transparent
                        text-center
                        subscriber-avatar
                      "
                    >
                      <validation-provider
                        tag="div"
                        rules="required"
                        name="Package Name"
                        v-slot="{ errors }"
                      >
                        <h3 class="text-uppercase text-white">
                          <input
                            type="text"
                            class="
                              form-control
                              text-uppercase text-center
                              fw-medium
                            "
                            placeholder="Enter Package Name"
                            name=""
                            id=""
                            v-model="form.package_name"
                          />
                        </h3>
                        <div class="text-danger">{{ errors[0] }}</div>
                      </validation-provider>

                      <h4 class="text-uppercase text-white mt-3 fw-light">
                        BILLED ANNUALLY
                      </h4>
                    </div>
                    <div class="card-body py-0 px-4 px-lg-4 px-xxl-5">
                      <validation-provider
                        tag="div"
                        rules="required|numeric"
                        name="Package Amount"
                        v-slot="{ errors }"
                      >
                        <h4 class="card-title text-center mt-4 mb-4">
                          <input
                            style="font-size: 24px"
                            type="text"
                            class="form-control text-center fw-medium"
                            placeholder="Enter Package Amount"
                            name=""
                            id=""
                            v-model="form.package_amount"
                          />
                        </h4>
                        <div class="text-danger py-0 px-4 px-lg-4 px-xxl-5">
                          {{ errors[0] }}
                        </div>
                      </validation-provider>

                      <validation-provider
                        tag="div"
                        rules="required"
                        name="Package Description"
                        v-slot="{ errors }"
                      >
                        <ul class="p-0 m-0 subs-list">
                          <input
                            type="text"
                            class="
                              form-control
                              text-uppercase text-center
                              fw-medium
                            "
                            placeholder="Enter Description"
                            name=""
                            id=""
                            v-model="form.description"
                          />
                        </ul>
                        <div class="text-danger py-0 px-4 px-lg-4 px-xxl-5">
                          {{ errors[0] }}
                        </div>
                      </validation-provider>
                    </div>
                    <div
                      class="card-footer border-0 bg-transparent text-center"
                    >
                      <div class="d-block">
                        <button
                          type="submit"
                          data-bs-toggle="modal"
                          data-bs-target=".subscription-updated"
                          class="btn btn-primary d-inline-block m-1"
                        >
                          Save
                        </button>
                        <a
                          @click="$router.go(-1)"
                          class="btn btn-blue d-inline-block m-1"
                          >Cancel</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </ValidationObserver>
          </div>
        </div>
      </section>
    </div>
  </div>
</template> -->
<!-- <script>
// import { mapActions, mapState } from 'vuex';
// export default {
//     components: {
//     },
//     data() {
//         return {
//             plans : {},
//             type : '',
//             entries : 10,
//             search : null,
//             form:{
//                 package_name:'',
//                 package_amount:'',
//                 description:'',
//                 duration:'BILLED ANNUALLY',

//             },
//             popupMsg: '',
//             updatingStatus: "",
//             confirmation_popupMsg: "",
//         };
//     },
//     created() {

//         let { page } = this.$route.query;
//         this.fetch(page);
//     },
//     watch: {
//         search: function(val, oldVal) {
//             this.fetch();
//         },
//         entries: function(val, oldVal) {
//             this.fetch();
//         },
//         type: function(val, oldVal) {
//             this.fetch();
//         },

//     },
//     methods: {
//         ...mapActions('admin', ['getAll','store','manageStatusMed']),

//            async update() {
//             let fd = new FormData();
//             fd.append('_method', 'POST');
//             this.buildFormData(fd,this.form);
//             let params = {
//                 route: route('admin.users.plan.add'),
//                 method: 'POST',
//                 data: fd,
//             };
//             let {data} = await this.store(params);
//             this.$snotify.success(data.message);
//             this.$router.push({name: 'admin.packages.index'});
//         },
//            async create(){
//             try {
//                 let fd = new FormData();
//                 this.buildFormData(fd,this.form);
//                 let {data} = await this.store({
//                     route : route('admin.users.medicine'),
//                     method: 'POST',
//                     data: fd,
//                 });
//                 if(data.status){
//                     this.$snotify.success(data.msg);

//                      this.form.medicine_type = '';
//                      this.form.medicine_volume='';
//                      this.fetch();
//                     // this.$router.push({ name: 'admin.packages.index',params : {type : 'plans'} });
//                 }
//             } catch (error) {
//                 let {errors,msg} = error.response.data
//                 if(error.status != 200){
//                     this.errorMessage = 'something went wrong';
//                 }
//             }
//         },
//         fetchFilteredData(e){
//             this.currentStatus = e.target.value;
//             this.fetch();
//         },

//         clearCalandar(){
//             this.dateFrom = '';
//             this.dateTill = '';
//             this.fetch();
//         },
//             changeStatusPopUp(user, status){
//             $('#activate-user-modal').modal('show');

//             if(status == 'inactive'){
//                 this.popupMsg =  'Are you sure you want to mark as In-Active?';
//                 this.updatingStatus = "0";
//             }else{
//                 this.popupMsg = 'Are you sure you want to mark as Active?';
//                 this.updatingStatus = "1";
//             }
//             this.editUser = {};
//             this.editUser = user;
//         },
//           async changeStatus(){

//             let users = this.editUser;
//             let { data } = await this.manageStatusMed({userId: users.id, status: this.updatingStatus});
//             if(data.status){
//                  this.fetch();
//                 var index = await _.findIndex(this.users.data, function(o) { return o.id == users.id; });
//                 this.users.data[index]['status'] = data.status;
//             }
//             if(this.updatingStatus == "1"){
//                 this.confirmation_popupMsg = 'Active Successfully!';
//             }else{
//                 this.confirmation_popupMsg = 'Inactive Successfully!';
//             }
//             $('#activated-user-modal').modal('show');
//             setTimeout(()=>{
//                 $('#activated-user-modal').modal('hide');
//             }, 1500);
//         },
//     }
// }

//
</script>
