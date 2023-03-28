<template>

<section v-if="!$user" class="login-wrap">
    <div class="" >
                <router-view></router-view>
                <vue-snotify></vue-snotify>
                <password-recovery></password-recovery>
        </div>
    </section>
    <Admin v-else />
</template>
<script>
const Admin = () => import('@views/Layout/admin/Admin.vue');
const PasswordRecovery = () => import('@core/components/Popups/password-recovery/Popup.vue');

export default {
    components: {
        Admin,
        PasswordRecovery,
    },
     computed: {
    Image() {
      return window.Laravel.base_url + "/admin/images/bg-login.jpg";
    }
  }
}

</script>
