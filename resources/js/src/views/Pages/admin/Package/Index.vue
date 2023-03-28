<template>
  <div class="app-content content">
    <div class="content-wrapper">
      <!-- Basic form layout section start -->
      <section id="subscription_plans_manage" class="subscription-plans-page">
        <div class="page-title mb-4">
          <div class="row">
            <div class="col-12">
              <h2>Subscription Plans</h2>
            </div>
          </div>
        </div>
        <div class="content-body bg-white rounded-10 shadow-none p-4 p-lg-5">
          <div class="row">
            <div class="media-left flex-shrink-0 mb-5 mb-lg-0 position-right">
              <!-- <router-link
                :to="{ name: 'admin.packages.create' }"
                class="btn btn-secondary px-4 mt-3 mb-5"
                ><i class="bi bi-x-circle pr-2"></i>Add New</router-link
              > -->
            </div>

            <div
              class="col-md-6 col-lg-6 col-xxl-4"
              v-for="(plan, index) in plans"
              :key="index"
            >
              <div class="card subscriber-card rounded-10">
                <!-- <a class="dropdown-item mb-1" @click="deletePackage(plan.id)"
                  ><i class="fa fa-trash" aria-hidden="true"></i
                ></a> -->

                <div
                  class="
                    card-header
                    px-4
                    bg-transparent
                    text-center
                    subscriber-avatar
                  "
                >
                  <h3 class="text-uppercase text-white">
                    {{ plan.package_name }}
                  </h3>
                  <h4 class="text-uppercase text-white fw-light mt-3">
                    {{ plan.duration }}
                  </h4>
                </div>
                <div class="card-body py-0 px-4 px-lg-4 px-xxl-5">
                  <h4 class="card-title text-center mt-4 mb-4">
                    AED {{ plan.package_amount }}
                  </h4>
                  <ul class="p-0 m-0 subs-list">
                    <li class="d-flex">
                      <i class="fa fa-check-circle"></i> {{ description[0] }}
                    </li>
                    <li class="d-flex">
                      <i class="fa fa-check-circle"></i>{{ description[1] }}
                    </li>
                    <li class="d-flex">
                      <i class="fa fa-check-circle"></i> {{ description[2] }}
                    </li>
                    <li class="d-flex">
                      <i class="fa fa-check-circle"></i> {{ description[3] }}
                    </li>
                  </ul>
                </div>
                <div class="card-footer border-0 bg-transparent text-center">
                  <div class="d-block">
                    <router-link
                      class="btn btn-primary d-inline-block"
                      :to="{
                        name: 'admin.packages.edit',
                        params: { id: plan.id },
                      }"
                    >
                      Edit</router-link
                    >
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
import { mapActions, mapState } from "vuex";
export default {
  components: {},
  data() {
    return {
      description: [
        "PRO Badge",
        "Dark Mode",
        "Ads Free",
        "Data export to excel, word, pdf formats.",
      ],
      plans: {},
      type: "",
      entries: 10,
      search: null,
      form: {
        medicine_type: "",
        medicine_volume: "",
      },
      popupMsg: "",
      updatingStatus: "",
      confirmation_popupMsg: "",
    };
  },
  created() {
    let { page } = this.$route.query;
    this.fetch(page);
  },
  watch: {
    search: function (val, oldVal) {
      this.fetch();
    },
    entries: function (val, oldVal) {
      this.fetch();
    },
    type: function (val, oldVal) {
      this.fetch();
    },
  },
  methods: {
    ...mapActions("admin", [
      "getAll",
      "store",
      "manageStatusMed",
      "deletePackages",
    ]),
    async fetch(page = 1) {
      let { type, status } = this.$route.params;
      let params = {
        route: route("admin.users.plan"),
        data: {
          page,
          type,
          status: this.currentStatus,
          search: this.search,
          entries: this.entries,
          type: this.type,
        },
      };
      let { data } = await this.getAll(params);
      this.plans = data.plan;
      console.log(this.plans);
    },
    async create() {
      try {
        let fd = new FormData();
        this.buildFormData(fd, this.form);
        let { data } = await this.store({
          route: route("admin.users.medicine"),
          method: "POST",
          data: fd,
        });
        if (data.status) {
          this.$snotify.success(data.msg);

          this.form.medicine_type = "";
          this.form.medicine_volume = "";
          this.fetch();
          // this.$router.push({ name: 'admin.packages.index',params : {type : 'plans'} });
        }
      } catch (error) {
        let { errors, msg } = error.response.data;
        if (error.status != 200) {
          this.errorMessage = "something went wrong";
        }
      }
    },
    fetchFilteredData(e) {
      this.currentStatus = e.target.value;
      this.fetch();
    },

    clearCalandar() {
      this.dateFrom = "";
      this.dateTill = "";
      this.fetch();
    },
    // async deletePackage(user) {
    //   console.log(user, "delete pakage");
    //   let users = this.user;
    //   let { data } = await this.deletePackages({
    //     id: users,
    //   });
    //   if (data.status) {
    //     this.$snotify.success(data.msg);
    //   }
    // },
    changeStatusPopUp(user, status) {
      $("#activate-user-modal").modal("show");

      if (status == "inactive") {
        this.popupMsg = "Are you sure you want to mark as In-Active?";
        this.updatingStatus = "0";
      } else {
        this.popupMsg = "Are you sure you want to mark as Active?";
        this.updatingStatus = "1";
      }
      this.editUser = {};
      this.editUser = user;
    },
    async changeStatus() {
      let users = this.editUser;
      let { data } = await this.manageStatusMed({
        userId: users.id,
        status: this.updatingStatus,
      });
      if (data.status) {
        this.fetch();
        var index = await _.findIndex(this.users.data, function (o) {
          return o.id == users.id;
        });
        this.users.data[index]["status"] = data.status;
      }
      if (this.updatingStatus == "1") {
        this.confirmation_popupMsg = "Active Successfully!";
      } else {
        this.confirmation_popupMsg = "Inactive Successfully!";
      }
      $("#activated-user-modal").modal("show");
      setTimeout(() => {
        $("#activated-user-modal").modal("hide");
      }, 1500);
    },
  },
};
</script>
