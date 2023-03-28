
import meta from './meta';

const web = {
    layout: () => import('@views/Layout/Web.vue').then(m => m.default),
    home: () => import('@views/Pages/web/Home.vue'),
    about: () => import('@views/Pages/web/About.vue'),
    contact: () => import('@views/Pages/web/Contact.vue'),
    auth: {
        login: () => import('@views/Pages/web/Auth/Login.vue'),
        register: {
            index: () => import('@views/Pages/web/Auth/Register/Index.vue'),
            owner: () => import('@views/Pages/web/Auth/Register/Owner.vue'),
            employee: () => import('@views/Pages/web/Auth/Register/Employee.vue')
        },
    },
    account: {
        index: () => import('@views/Pages/web/Account/Index.vue'),
        edit: () => import('@views/Pages/web/Account/Edit.vue'),
        password: () => import('@views/Pages/web/Account/Password.vue'),
        application: () => import('@views/Pages/web/Account/Application.vue'),
    },
    subscription: {
        index: () => import('@views/Pages/web/Subscriptions/Index.vue'),
        show: () => import('@views/Pages/web/Subscriptions/Show.vue'),
    },
    password: {
        email: () => import('@views/Pages/web/Password/Email.vue'),
        code: () => import('@views/Pages/web/Password/Code.vue'),
        new: () => import('@views/Pages/web/Password/Password.vue'),
    },
    properties: {
        index: () => import('@views/Pages/web/Property/Index.vue'),
        create: () => import('@views/Pages/web/Property/Create.vue'),
        show: () => import('@views/Pages/web/Property/Show.vue'),
        edit: () => import('@views/Pages/web/Property/Edit.vue'),
    },
    employees: {
        index: () => import('@views/Pages/web/Employee/Index.vue'),
        create: () => import('@views/Pages/web/Employee/Create.vue'),
        new: () => import('@views/Pages/web/Employee/New.vue'),
        show: () => import('@views/Pages/web/Employee/Show.vue'),
        edit: () => import('@views/Pages/web/Property/Edit.vue'),
        tasks: () => import('@views/Pages/web/Employee/Tasks.vue'),
    },
    tasks: {
        board: () => import('@views/Pages/web/Task/Board.vue'),
        // calendar: () => import('@views/Pages/web/Task/Calendar.vue'),
        index: () => import('@views/Pages/web/Task/Index.vue'),
        show: () => import('@views/Pages/web/Task/Show.vue'),
    },
    errors : {
        error404 : ()=> import('@views/Pages/web/Errors/404.vue'),
    },
};

const routes = {
        path: '/',
        components: {
            default: web.layout,
        },
        children: [
            /*Web Pages */
            {
                path: '/',
                component: web.home,
                name: 'web.home',
                meta,
            },
            {
                path: 'about-us',
                component: web.about,
                name: 'web.about',
                meta,
            },
            {
                path: 'contact-us',
                component: web.contact,
                name: 'web.contact',
                meta,
            },
            {
                path: 'login',
                component: web.auth.login,
                name: 'web.auth.login',
                meta: { ...meta, loggedInCan: false },

            },
            {
                path: 'register',
                component: web.auth.register.index,
                name: 'web.auth.register.index',
                meta: { ...meta, loggedInCan: false },
            },
            {
                path: 'register/owner',
                component: web.auth.register.owner,
                name: 'web.auth.register.owner',
                meta: { ...meta, loggedInCan: false },
            },
            {
                path: 'register/employee',
                component: web.auth.register.employee,
                name: 'web.auth.register.employee',
                meta: { ...meta, loggedInCan: false },
            },
            {
                path: 'forget-password',
                component: web.password.email,
                name: 'web.password.email',
                meta: { ...meta, loggedInCan: false },
            },
            {
                path: 'forget-password/verify-code',
                component: web.password.code,
                name: 'web.password.code',
                meta: { ...meta, loggedInCan: false },
            },
            {
                path: 'forget-password/password',
                component: web.password.new,
                name: 'web.password.new',
                meta: { ...meta, loggedInCan: false },
            },
            {
                path: 'account',
                component: web.account.index,
                name: 'web.account.index',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'account/edit',
                component: web.account.edit,
                name: 'web.account.edit',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'account/application/resubmit',
                component: web.account.application,
                name: 'web.account.application',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'account/password/change',
                component: web.account.password,
                name: 'web.account.password',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'subscriptions',
                component: web.subscription.index,
                name: 'web.subscription.index',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'subscriptions/:pivot/:subscription',
                component: web.subscription.show,
                name: 'web.subscription.show',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'properties',
                component: web.properties.index,
                name: 'web.properties.index',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'properties/create',
                component: web.properties.create,
                name: 'web.properties.create',
                meta: { ...meta, requiresAuth: true, },
            },
            {
                path: 'properties/:id',
                component: web.properties.show,
                name: 'web.properties.show',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'properties/:property/edit',
                component: web.properties.edit,
                name: 'web.properties.edit',
                meta: { ...meta, requiresAuth: true },
            },
            // my employees
            {
                path: 'employees',
                component: web.employees.index,
                name: 'web.employees.index',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'employees/create',
                component: web.employees.create,
                name: 'web.employees.create',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'employees/:employee/tasks',
                component: web.employees.tasks,
                name: 'web.employees.tasks',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'employees/:employee',
                component: web.employees.show,
                name: 'web.employees.show',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'employees/:employee/new',
                component: web.employees.new,
                name: 'web.employees.new',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'assigned-tasks/log',
                component: web.tasks.index,
                name: 'web.tasks.index',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'assigned-tasks/:task',
                component: web.tasks.show,
                name: 'web.tasks.show',
                meta: { ...meta, requiresAuth: true },
            },
            {
                path: 'tasks/:type',
                component: web.tasks.board,
                name: 'web.tasks.board',
                meta: { ...meta, requiresAuth: true },
                beforeEnter(to,from,next){
                    if(to.params.type == 'board' || to.params.type == 'calendar'){
                        next();
                    }else{
                        next({name : 'web.404'});
                    }
                },
            },
            {
                path: '404',
                component: web.errors.error404,
                name: 'web.404',
                meta: { ...meta, requiresAuth : false },
            },
            {
                path: '*',
                redirect: {name : 'web.404'},
            },
        ],
    };
export default routes;