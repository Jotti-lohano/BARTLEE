import router from './index.js';

function isLoggedIn() {
    return window.Laravel.isLoggedin;
}

function isAdminLoggedIn() {
    return window.Laravel.isLoggedin && window.Laravel.as == 'admin';
}
let userPermissions = isAdminLoggedIn()?[null,..._.map(window.Laravel.user.permissions,'value')]:[];
// check authentication 
router.beforeEach((to, from, next) => {

    if (to.name.includes('admin.')) {

        // validating non login pages.
        if (isAdminLoggedIn()) {
            if (to.meta.requiresAuth && to.meta.loggedInCan /*&& (userPermissions.indexOf(to.meta.permission) !== -1 || window.Laravel.user.role == 'super_admin')*/) {
                return next();
            } else if (!to.meta.requiresAuth && !to.meta.loggedInCan) {
                // console.log('saddssd');
                return next({ name: 'admin.dashboard' });
                // return next({ name: 'admin.auth.login' });
            } else {
            // console.log(userPermissions,to.meta.permission);
                return next({name : 'admin.404'});
            }
            return;
        }
        // validating access for actors as unauthenticated
        if (to.meta.requiresAuth) {
            return next({ name: 'admin.auth.login' });
        }
    }/* else {
        // validating non login pages.
        if (isLoggedIn()) {
            if (to.meta.requiresAuth && to.meta.loggedInCan) {
                return next();
            } else if (!to.meta.requiresAuth && !to.meta.loggedInCan) {
                return next({ name: 'web.home' });
            } else {
                return next();
            }
            return;
        }
        // validating access for actors as unauthenticated
        if (to.meta.requiresAuth) {
            return next({ name: 'web.home' });
        }
    }*/
    return next();


});
