export default{
	SET_HOME_DATA(state,data){
		console.log(data);
		Vue.set(state,'home',data);

	},
	SET_NOTIFICATIONS(state,data){
		Vue.set(state,'notifications',data);
	},
	MARK_NOTIFICATION_READ(state,data){
		let index = _.findIndex(state.bell_notifications,(item)=>{return item.id == data.id});
		Vue.delete(state.bell_notifications,index);
		Vue.set(state,'notification_count',--state.notification_count);
	},
	SET_BELL_NOTIFICATIONS(state,data){

		Vue.set(state,'notification_count',data.notification_count);
		Vue.set(state,'bell_notifications',data.notifications);
	},
	PUSH_BELL_NOTIFICATIONS(state,notification){
		let notifications = state.bell_notifications;
		notifications.unshift(notification);
		let count = ++state.notification_count
		Vue.set(state,'bell_notifications',notifications);
		Vue.set(state,'notification_count',count);
	},
	SET_SEARCH(state,value){
		Vue.set(state,'search',value);
	},
	SET_ENTRIES(state,value){
		Vue.set(state,'entries',value);
	},
	CHANGE_USER_STATUS(state,data){
		let index = _.findIndex(state.users.data,(user)=>{ return user.id == data.id});
		state.users.data.splice(index,1);
	},

	SET_USERS(state,data){
		Vue.set(state,'users',data);
	},
	SET_OWNERS(state,data){
		Vue.set(state,'owners',data);
	},
	
	SET_USER(state,data){
		Vue.set(state,'user',data);
	},
	SET_PROPERTIES(state,data){
		Vue.set(state,'properties',data);
	},
	SET_PROPERTY(state,data){
		Vue.set(state,'property',data);
	},
	CHANGE_PROPERTY_STATUS(state,data){
		let index = _.findIndex(state.properties.data,(property)=>{ return property.id == data.id});
		state.properties.data.splice(index,1);
	},
	SET_SUBSCRIPTIONS(state,data){

		Vue.set(state,'subscriptions',data);
	},
	SET_SUBSCRIPTION(state,data){
		Vue.set(state,'subscription',data);
	},
	SET_TASKS(state,data){
		Vue.set(state,'tasks',data);
	},
	SET_TASK(state,data){
		Vue.set(state,'task',data);
	},
	SET_FEEDBACKS(state,data){
		Vue.set(state,'feedbacks',data);
	},
	SET_FEEDBACK(state,data){
		Vue.set(state,'feedback',data);
	},
	SET_ADS(state,data){
		Vue.set(state,'ads',data);
	},
	SET_AD(state,data){
		Vue.set(state,'ad',data);
	},
	SET_GROUPS(state,data){
		Vue.set(state,'groups',data);
	},
	SET_GROUP(state,data){
		Vue.set(state,'group',data);
	},
	SET_PACKAGES(state,data){
		Vue.set(state,'packages',data);
	},
	SET_ADMINS(state,data){
		Vue.set(state,'admins',data);
	},
	SET_ADMIN(state,data){
		Vue.set(state,'admin',data);
	},
	SET_PROMOTIONALS(state,data){
		Vue.set(state,'promotionals',data);
	},
	SET_PROMOTIONAL(state,data){
		Vue.set(state,'promotional',data);
	},
	DELETE_ADMIN(state,data){
		let index = _.findIndex(state.admins.data,(admin)=>{ return admin.id == data.id});
		state.admins.data.splice(index,1);
	},
	remove_property(state,data){
		let requestedData = data.data;
		let index = _.findIndex(state.employee.properties,(property)=>{return property.id == requestedData.property});
		state.employee.properties.splice(index,1);
	},
	remove_employee(state,id){
		let index = _.findIndex(state.users.data,(employee)=>{return employee.id == id});
		state.users.data.splice(index,1);
	},
	set_users(state,data){
		Vue.set(state,'all_users',data);
	},
	set_properties(state,data){
		// let properties = state.employee.properties;
		state.employee.properties.push(data);
		// Vue.set(state.employee.properties)
	},
}