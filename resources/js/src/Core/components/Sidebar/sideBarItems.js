const sidebarItems = [
    {
    	componentName : 'admin.dashboard',
    	iconClasses : 'fa fa-home',
    	name : 'Dashboard',
        permission : 'admin.dashboard',
    },
    {
    	componentName : 'admin.users.index',
    	iconClasses : 'fa fa-user-circle',
    	name : 'Users',
    },
    {
    	componentName : 'admin.medicine.index',
    	iconClasses : 'fa fa-laptop-medical',
    	name : 'Medicine Type Management',
    },
    {
    	componentName : 'admin.subscription.index',
    	iconClasses : 'fa fa-money-bill-alt',
    	name : 'Subscription logs',
    },
    {
    	componentName : 'admin.packages.index',
    	iconClasses : 'fa fa-credit-card',
    	name : 'Subscription Plans',
    },
    {
    	componentName : 'admin.faqs.index',
    	iconClasses : 'fa fa-file-alt',
    	name : 'Inquiry Logs',
		defaultParams : {type : 'plans'},
    }
];
export default sidebarItems;
