<template>
<div class="" id="">
    <sidebar></sidebar>
    <!-- Page content wrapper-->
    <div id="" class="">
        <!-- Top navigation-->
        <navbar></navbar>
        <div class="">
            <transition name="fade">
                <router-view :key="$route.fullPath"></router-view>
            </transition>
        </div>
    </div>
     <vue-snotify></vue-snotify>
</div>

</template>
<script>
const Navbar = () => import('@core/components/Navbar/Navbar.vue');
const Sidebar = () => import('@core/components/Sidebar/Sidebar.vue');
import { mapMutations, mapActions } from 'vuex';
// const ChangePassword = () => import('@core/components/ChangePassword.vue');
export default {
    data() {
        return {
            componentKey: 0,
        };
    },
    components: {
        Navbar,
        Sidebar,
        // ChangePassword
    },
    methods : {
        ...mapActions('admin', ['getAll']),
        ...mapMutations('admin', ['SET_BELL_NOTIFICATIONS','PUSH_BELL_NOTIFICATIONS']),
        async fetch() {
            let { status } = this.$route.params;
            let params = {
                route: route('admin.notification.bell'),
                mutation: 'SET_BELL_NOTIFICATIONS',
                variable: 'data',
                data: {}
            };
            let { data } = await this.getAll(params);

        }
    },
    created(){
        // this.fetch();
    },
    mounted() {
            Echo.private('App.Models.Admin.' + this.$user.id).notification((notification) => {
                // console.log();
                // this.fetch();
                this.PUSH_BELL_NOTIFICATIONS(notification);
            });
    },
    destroy(){
        window.location.reload();
    }
}

</script>