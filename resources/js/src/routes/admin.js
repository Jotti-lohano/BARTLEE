
import meta from './meta';
const admin = {
    layout: {
        fullPage: () => import('@views/Layout/admin/Full-page.vue').then(m => m.default),
    },
    auth: {
        login: () => import('@views/Pages/admin/Auth/Login.vue'),
    },
    pr: {
        email: () => import('@views/Pages/admin/Password/Email.vue'),
        code: () => import('@views/Pages/admin/Password/Code.vue'),
        new: () => import('@views/Pages/admin/Password/Password.vue'),
    },
    account: {
        index: () => import('@views/Pages/admin/Account/Index.vue'),
        edit: () => import('@views/Pages/admin/Account/Edit.vue'),
        password: () => import('@views/Pages/admin/Account/Password.vue'),
    },
    error404: () => import('@views/Pages/admin/Errors/404.vue'),
    dashboard: () => import('@views/Pages/admin/Dashboard/Dashboard.vue'),
    users: {
        index: () => import('@views/Pages/admin/User/Index.vue'),
        show: () => import('@views/Pages/admin/User/Show.vue'),
        showMedicine: () => import('@views/Pages/admin/User/ShowMedicien.vue'),
        logs: () => import('@views/Pages/admin/User/Logs.vue'),
        appointmentDetails: () => import('@views/Pages/admin/User/components/AppointmentDetails.vue'),


    },
    medicine: {
        index: () => import('@views/Pages/admin/Medicine/Index.vue'),
        show: () => import('@views/Pages/admin/Ambassadors/Show.vue'),
        edit: () => import('@views/Pages/admin/Medicine/Edit.vue'),
    },

    subscription: {
        index: () => import('@views/Pages/admin/Subscriptions/Index.vue'),
        create: () => import('@views/Pages/admin/Subscriptions/Create.vue'),

    },


    packages: {
        index: () => import('@views/Pages/admin/Package/Index.vue'),
        // show : ()=> import('@views/Pages/admin/Offers/Show.vue'),
    },
    events: {
        index: () => import('@views/Pages/admin/Events/Index.vue'),
        show: () => import('@views/Pages/admin/Events/Show.vue'),
    },

    boosts: {
        index: () => import('@views/Pages/admin/Boosts/Index.vue'),
        show: () => import('@views/Pages/admin/Boosts/Show.vue'),
        create: () => import('@views/Pages/admin/Boosts/Create.vue'),
    },

    wheel: {
        index: () => import('@views/Pages/admin/SpinningWheel/Index.vue'),
        create: () => import('@views/Pages/admin/SpinningWheel/Create.vue'),
        edit: () => import('@views/Pages/admin/SpinningWheel/Edit.vue'),
    },
    finances: {
        index: () => import('@views/Pages/admin/Finance/Index.vue'),
    },
    configuration: {
        index: () => import('@views/Pages/admin/Configuration/Index.vue'),
        create: () => import('@views/Pages/admin/Configuration/Create.vue'),
        edit: () => import('@views/Pages/admin/Configuration/Edit.vue'),
        show: () => import('@views/Pages/admin/Configuration/Show.vue'),
    },
    challenges: {
        index: () => import('@views/Pages/admin/Challenges/Index.vue'),
        show: () => import('@views/Pages/admin/Challenges/Show.vue'),
        create: () => import('@views/Pages/admin/Challenges/Create.vue'),
    },
    reports: {
        index: () => import('@views/Pages/admin/Reports/Index.vue'),
    },
    packages: {
        index: () => import('@views/Pages/admin/Package/Index.vue'),
        show: () => import('@views/Pages/admin/Package/Show.vue'),
        create: () => import('@views/Pages/admin/Package/Create.vue'),
        edit: () => import('@views/Pages/admin/Package/Edit.vue'),
    },
    admins: {
        index: () => import('@views/Pages/admin/Admin/Index.vue'),
        create: () => import('@views/Pages/admin/Admin/Create.vue'),
        edit: () => import('@views/Pages/admin/Admin/Edit.vue'),
        show: () => import('@views/Pages/admin/Admin/Show.vue'),
    },
    cms: {
        index: () => import('@views/Pages/admin/cms/Index.vue'),
        create: () => import('@views/Pages/admin/cms/Create.vue'),
        edit: () => import('@views/Pages/admin/cms/Edit.vue'),
    },
    faqs: {
        index: () => import('@views/Pages/admin/Faqs/Index.vue'),
        details: () => import('@views/Pages/admin/Faqs/View.vue'),
    },
    promos: {
        index: () => import('@views/Pages/admin/PromotionalCodes/Index.vue'),
        create: () => import('@views/Pages/admin/PromotionalCodes/Create.vue'),
        edit: () => import('@views/Pages/admin/PromotionalCodes/Edit.vue'),
        show: () => import('@views/Pages/admin/PromotionalCodes/Show.vue'),
    },
    notifications: {
        index: () => import('@views/Pages/admin/Notification/Index.vue'),
    },
};


const routes = {
    path: '/',
    components: {
        default: admin.layout.fullPage,
    },
    children: [
        {
            path: '/',
            component: admin.auth.login,
            name: 'admin.auth.login',
            meta: { ...meta, loggedInCan: false },
        },
        {
            path: '/pr1',
            component: admin.pr.email,
            name: 'admin.pr.email',
            meta: { ...meta, loggedInCan: false },
        },
        {
            path: '/pr2',
            component: admin.pr.code,
            name: 'admin.pr.code',
            meta: { ...meta, loggedInCan: false },
        },
        {
            path: '/pr3',
            component: admin.pr.new,
            name: 'admin.pr.new',
            meta: { ...meta, loggedInCan: false },
        },
        {
            path: 'dashboard',
            component: admin.dashboard,
            name: 'admin.dashboard',
            meta: { ...meta, requiresAuth: true, permission: null },
        },
        {
            path: 'account',
            component: admin.account.index,
            name: 'admin.account.index',
            meta: { ...meta, requiresAuth: true, permission: null },
        },
        {
            path: 'account/edit',
            component: admin.account.edit,
            name: 'admin.account.edit',
            meta: { ...meta, requiresAuth: true, permission: null },
        },
        {
            path: 'account/password/change',
            component: admin.account.password,
            name: 'admin.account.password',
            meta: { ...meta, requiresAuth: true, permission: null },
        },
        {
            path: 'users/:type?',
            component: admin.users.index,
            name: 'admin.users.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.users' },
        },
        {
            path: 'user/:type/:user',
            component: admin.users.show,
            name: 'admin.users.show',
            meta: { ...meta, requiresAuth: true, permission: 'admin.users' },
        },
        {
            path: 'appointment-details/:id',
            component: admin.users.appointmentDetails,
            name: 'admin.users.appointmentDetails',
            meta: { ...meta, requiresAuth: true, permission: 'admin.users' },
        },
        {
            path: 'user-medicine/:id',
            component: admin.users.showMedicine,
            name: 'admin.users.showMedicine',
            meta: { ...meta, requiresAuth: true, permission: 'admin.users' },
        },
        {
            path: 'medicine-management/',
            component: admin.medicine.index,
            name: 'admin.medicine.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.medicine' },
        },
        {
            path: 'medicine-management/:id',
            component: admin.medicine.edit,
            name: 'admin.medicine.edit',
            meta: { ...meta, requiresAuth: true, permission: 'admin.medicine' },
        },
        {
            path: 'subscription-logs/',
            component: admin.subscription.index,
            name: 'admin.subscription.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.subscription' },
        },
        {
            path: 'subscription-create/',
            component: admin.subscription.create,
            name: 'admin.subscription.create',
            meta: { ...meta, requiresAuth: true, permission: 'admin.subscription' },
        },
        {
            path: 'packages/',
            component: admin.packages.index,
            name: 'admin.packages.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.packages' },
        },

        {
            path: 'packages-create/',
            component: admin.packages.create,
            name: 'admin.packages.create',
            meta: { ...meta, requiresAuth: true, permission: 'admin.packages' },
        },
        {
            path: 'packages/edit/:id',
            component: admin.packages.edit,
            name: 'admin.packages.edit',
            meta: { ...meta, requiresAuth: true, permission: 'admin.packages' }
        },
        // {
        //     path: 'offers-details/:id',
        //     component: admin.offers.show,
        //     name: 'admin.offers.show',
        //     meta: { ...meta, requiresAuth: true,permission : 'admin.offers' },
        // },
        {
            path: 'inquiry-logs/',
            component: admin.faqs.index,
            name: 'admin.faqs.index',
            meta: { ...meta, requiresAuth: true, permission: null }
        },
        {
            path: 'inquiry-log/:id',
            component: admin.faqs.details,
            name: 'admin.faqs.details',
            meta: { ...meta, requiresAuth: true, permission: null }
        },
        {
            path: 'events/',
            component: admin.events.index,
            name: 'admin.events.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.events' },
        },
        {
            path: 'event-details/:id',
            component: admin.events.show,
            name: 'admin.events.show',
            meta: { ...meta, requiresAuth: true, permission: 'admin.events' },
        },
        {
            path: 'boosts/',
            component: admin.boosts.index,
            name: 'admin.boosts.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.boosts' },
        },
        {
            path: 'boosts/create',
            component: admin.boosts.create,
            name: 'admin.boosts.create',
            meta: { ...meta, requiresAuth: true, permission: 'admin.boosts' },
        },
        {
            path: 'boosts-details/:id',
            component: admin.boosts.show,
            name: 'admin.boosts.show',
            meta: { ...meta, requiresAuth: true, permission: 'admin.boosts' },
        },
        {
            path: 'spinning-wheel/',
            component: admin.wheel.index,
            name: 'admin.wheel.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.spinning-wheel' },
        },
        {
            path: 'spinning-wheel/create',
            component: admin.wheel.create,
            name: 'admin.wheel.create',
            meta: { ...meta, requiresAuth: true, permission: 'spinning-whee' }
        },
        {
            path: 'spinning-wheel/edit/:id',
            component: admin.wheel.edit,
            name: 'admin.wheel.edit',
            meta: { ...meta, requiresAuth: true, permission: 'spinning-whee' }
        },
        {
            path: 'finances/:type',
            component: admin.finances.index,
            name: 'admin.payments.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.finances' },
        },
        {
            path: 'configuration/:type',
            component: admin.configuration.index,
            name: 'admin.configuration.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.configuration' },
        },
        {
            path: 'configuration/create/:type',
            component: admin.configuration.create,
            name: 'admin.configuration.create',
            meta: { ...meta, requiresAuth: true, permission: 'admin.configuration' },
        },
        {
            path: 'configuration/edit/:type/:id',
            component: admin.configuration.edit,
            name: 'admin.configuration.edit',
            meta: { ...meta, requiresAuth: true, permission: 'admin.configuration' },
        },
        {
            path: 'configuration/show/:type/:id',
            component: admin.configuration.show,
            name: 'admin.configuration.show',
            meta: { ...meta, requiresAuth: true, permission: 'admin.configuration' },
        },


        /*{
            path: 'datatable-testing',
            component: admin.properties.datatable,
            name: 'admin.properties.datatable',
            meta: { ...meta, requiresAuth: true,permission : null },
        },*/
        {
            path: 'reports',
            component: admin.reports.index,
            name: 'admin.reports.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.reports' }
        },
        // {
        //     path: 'packages/:type/:purchase?',
        //     component: admin.packages.index,
        //     name: 'admin.packages.index',
        //     meta: { ...meta, requiresAuth: true,permission : 'admin.packages' }
        // },
        // {
        //     path: 'packages/:type/create',
        //     component: admin.packages.create,
        //     name: 'admin.packages.create',
        //     meta: { ...meta, requiresAuth: true,permission : 'admin.packages' }
        // },

        // {
        //     path: 'packages/:id/:type',
        //     component: admin.packages.show,
        //     name: 'admin.packages.show',
        //     meta: { ...meta, requiresAuth: true,permission : 'admin.packages' }
        // },
        {
            path: 'admins',
            component: admin.admins.index,
            name: 'admin.admins.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.admins' }
        },
        {
            path: 'admins/create',
            component: admin.admins.create,
            name: 'admin.admins.create',
            meta: { ...meta, requiresAuth: true, permission: 'admin.admins' }
        },
        {
            path: 'admins/edit/:id',
            component: admin.admins.edit,
            name: 'admin.admins.edit',
            meta: { ...meta, requiresAuth: true, permission: 'admin.admins' }
        },
        {
            path: 'admins/:id',
            component: admin.admins.show,
            name: 'admin.admins.show',
            meta: { ...meta, requiresAuth: true, permission: 'admin.admins' }
        },

        {
            path: 'promos',
            component: admin.promos.index,
            name: 'admin.promos.index',
            meta: { ...meta, requiresAuth: true, permission: 'admin.promos' }
        },
        {
            path: 'promos/create',
            component: admin.promos.create,
            name: 'admin.promos.create',
            meta: { ...meta, requiresAuth: true, permission: 'admin.promos' }
        },
        {
            path: 'promos/edit/:id',
            component: admin.promos.edit,
            name: 'admin.promos.edit',
            meta: { ...meta, requiresAuth: true, permission: 'admin.promos' }
        },
        {
            path: 'promos/:id',
            component: admin.promos.show,
            name: 'admin.promos.show',
            meta: { ...meta, requiresAuth: true, permission: 'admin.promos' }
        },
        {
            path: 'notifications',
            component: admin.notifications.index,
            name: 'admin.notifications.index',
            meta: { ...meta, requiresAuth: true, permission: null }
        },
        {
            path: 'challenges/:type?',
            component: admin.challenges.index,
            name: 'admin.challenges.index',
            meta: { ...meta, requiresAuth: true, permission: null }
        },
        {
            path: 'challenges/create/:type?/:id?',
            component: admin.challenges.create,
            name: 'admin.challenges.create',
            meta: { ...meta, requiresAuth: true, permission: null }
        },
        {
            path: 'challenges/:type/:id',
            component: admin.challenges.show,
            name: 'admin.challenges.show',
            meta: { ...meta, requiresAuth: true, permission: null }
        },

        {
            path: 'content-management',
            component: admin.cms.index,
            name: 'admin.cms.index',
            meta: { ...meta, requiresAuth: true, permission: null }
        },
        {
            path: 'content-management/create',
            component: admin.cms.create,
            name: 'admin.cms.create',
            meta: { ...meta, requiresAuth: true, permission: null }
        },
        {
            path: 'content-management/:id/edit',
            component: admin.cms.edit,
            name: 'admin.cms.edit',
            meta: { ...meta, requiresAuth: true, permission: null }
        },
        {
            path: '404',
            name: 'admin.404',
            component: admin.error404,
            meta: { ...meta, requiresAuth: true, permission: null },
        },
        {
            path: '*',
            redirect: { name: 'admin.404', permission: null }
        },

    ],
};

export default routes;
