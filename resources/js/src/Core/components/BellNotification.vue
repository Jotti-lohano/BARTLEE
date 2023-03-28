<template>
	<li class="dropdown dropdown-notification nav-item">
					<a class="nav-link nav-link-label" href="#" data-bs-toggle="dropdown" aria-expanded="true">
								<i class="far fa-bell"></i> <span class="badge badge-pill badge-default badge-danger badge-default badge-up">{{	notification_count}}</span> </a>

		<ul class="dropdown-menu dropdown-menu-end">
			<li class="dropdown-menu-header">
				<div>
					<h6 class="dropdown-header text-center fw-bold mb-2">Notifications</h6>
				</div>
			</li>

             <!-- <router-link :to="{ name: 'admin.dashboard' }">

             </router-link> -->

			<li class="scrollable-container media-list ps-container ps-theme-dark"
				data-ps-id="75e644f2-605d-3ecc-f100-72d86e4a64d8">
				<!-- <a href="javascript:void(0)"> -->
					<div v-for="(notification, index) in bell_notifications" :key="index" class="media d-flex">

						<div class="media-left flex-shrink-0 align-self-top">
							<i class="far fa-bell"></i>
						</div>
						<div class="media-body flex-grow-1">
							<a @click="markRead(notification.id)" href="javascript:void(0)">
                                <router-link :to="{ name: notification.data.route }">
						<h6 class="media-heading">{{ notification.data.title }}</h6> </router-link>

						<small>
							<time class="date-meta" datetime="2015-06-11T18:29:20+08:00">{{ notification.created_at | newFormatDate}}</time>
							<time class="time-meta" datetime="2015-06-11T18:29:20+08:00">{{ notification.updated_at | newFormatTime }}</time>
						</small>
						</a>
					</div>

					</div>
				<!-- </a> -->


			</li>
			<li class="dropdown-menu-footer">
				<router-link class="dropdown-item theme-blue-txt text-center"
					:to="{ name: 'admin.notifications.index' }">View all</router-link>
			</li>

		</ul>
	</li>
</template>
<script>
export default {
    data() {
        return {
            bell_notifications: [],
            notification_count: [],
        }
    },
    async created() {
        await this.fetch();
    },
	async mounted() {
        await this.fetch();
    },
    methods: {
        async fetch() {
            let {data} = await axios.get('admin/notification/getNotification');
            this.bell_notifications = data.notifications;
            this.notification_count = data.notification_count;
			console.log(this.bell_notifications)

        },
        async markRead(id) {
            let index = this.bell_notifications.findIndex(item => item.id === id);
           await axios
                .post(`admin/notification/markAsRead/`, {id: id})
                .then((res) => {
                    this.$router.go({name: 'admin.notifications.index'});
                });
            this.$delete(this.bell_notifications, index);
        }
    }
}

</script>
