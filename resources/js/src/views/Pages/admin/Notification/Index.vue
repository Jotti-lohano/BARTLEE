<template>
  <div class="app-content content">
    <div class="content-wrapper">
      <section id="configuration" class="notifications-page">
        <div class="page-title mb-4">
          <div class="row">
            <div class="col-12">
              <h2>Notifications</h2>
            </div>
          </div>
        </div>
        <div class="content-body bg-white rounded-10 shadow-sm p-4 p-lg-5">
          <div class="row">
            <div class="col-12">
              <div
                class="card"
                v-for="(notification, index) in bell_notifications"
                :key="index"
              >
                <router-link :to="{ name: notification.data.route }">
                  <div class="media">
                    <div class="media-body align-self-center">
                      <p>
                        {{ notification.data.title }}
                      </p>
                      <div class="meta mt-1">
                        <time class="time-meta" datetime=""
                          >{{ notification.created_at | newFormatDate }}
                          -
                          {{ notification.created_at | newFormatTime }}</time
                        >
                      </div>
                    </div>
                  </div>
                </router-link>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card rounded-10 shadow-none">
              <div class="card-body p-4 p-lg-5"></div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      bell_notifications: [],
    };
  },
  async created() {
    await this.fetch();
  },
  methods: {
    async fetch() {
      let { data } = await axios.get("admin/notification/index");
      this.bell_notifications = data.notifications;
    },
  },
};
</script>
