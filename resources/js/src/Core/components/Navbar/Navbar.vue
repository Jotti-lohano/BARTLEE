<template>
    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-border"
    >
        <div class="navbar-wrapper w-100">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto">
                        <a
                            class="nav-link nav-menu-main menu-toggle hidden-xs"
                            href="#"
                            ><i class="ft-menu font-large-1"></i
                        ></a>
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="navbar-brand"
                            :to="{ name: 'admin.dashboard' }"
                            ><img
                                class="brand-logo img-fluid"
                                alt="stack admin logo"
                                src="images/logo-admin.png"
                        /></router-link>
                    </li>
                    <li class="nav-item d-md-none">
                        <a
                            class="nav-link open-navbar-container"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbar-mobile"
                            ><i class="fa fa-ellipsis-v"></i
                        ></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav me-auto float-start"></ul>
                    <ul class="nav navbar-nav float-end nav-right">
                        <bell-notification></bell-notification>
                        <!-- Notification -->

                        <!-- Notification -->

                        <li class="dropdown dropdown-user nav-item">
                            <a
                                class="dropdown-toggle nav-link dropdown-user-link"
                                href="#"
                                data-bs-toggle="dropdown"
                            >
                                <span class="avatar avatar-online">
                                    <img :src="$user.url" alt="avatar" />
                                </span>
                                <span class="user-name fw-medium">{{
                                    this.$user.name
                                }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <router-link
                                    class="dropdown-item"
                                    :to="{ name: 'admin.account.index' }"
                                    ><i class="fa fa-user"></i
                                    >Profile</router-link
                                >
                                <a class="dropdown-item" @click="logout()"
                                    ><i class="fa fa-power-off"></i>Logout</a
                                >
                            </div>
                        </li>
                        <!-- <li class="nav-item d-none d-md-block">
							<a class="nav-link nav-menu-main menu-toggle hidden-xs is-active" href="#"><i class="ft-menu"></i></a>
						</li> -->
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
const BellNotification = () => import("@core/components/BellNotification.vue");
const Confirm = () => import("@core/components/Popups/Confirm.vue");
export default {
    components: {
        BellNotification,
        Confirm,
    },
    mounted() {
        let script = document.createElement("script");
        script.setAttribute("src", "admin-assets/js/main.js");
        document.body.append(script);
    },
    methods: {
        toggleMenu() {
            let classes = document.body.classList;
            if (_.includes(classes, "menu-expanded")) {
                classes.remove("menu-expanded");
                classes.add("menu-collapsed");
            } else {
                classes.add("menu-expanded");
                classes.remove("menu-collapsed");
            }
        },
        async logout() {
            await axios.post(route("admin.account.logout"));
            this.$snotify.success("Logout Successfully");
            let self = this;
            this.$forceUpdate();
            setTimeout(function () {
                location.reload();
            }, 3000);
        },
    },
};
</script>
