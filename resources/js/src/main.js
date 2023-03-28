import Vue from 'vue';
window.Vue = Vue;
import App from './Core/App.vue';
import router from './routes/index.js';
require('./routes/guard.js');
require('@core/axios.js');

window.moment = require('moment');

const pagination = require('laravel-vue-pagination');
require('@core/mixins.js');
import store from '@/store/index.js';

// form Validation components
import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
import vSelect from 'vue-select'

// import Echarts from 'vue-echarts';
// import 'echarts/lib/chart/bar';

import * as rules from 'vee-validate/dist/rules';
import en from 'vee-validate/dist/locale/en.json';
// importing snotify for alert notifications 
import Snotify, { SnotifyPosition } from 'vue-snotify';

const TableSearch = ()=> import('@core/components/TableSearch.vue');
const Table = ()=> import('@core/components/Table/Index.vue');
import BarChart from '@core/components/Chart/BarChart.vue'
import ColumnChart from '@core/components/Chart/ColumnChart.vue';
import PieChart from '@core/components/Chart/PieChart.vue';
const options = {
    toast: {
        position: SnotifyPosition.rightTop
    }
};
// installing plugins
Vue.use(Snotify, options);


Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});
// Install English and Arabic locales.
localize({
  en
});


Vue.filter('newFormatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MMM D, YYYY');
    }
});

Vue.filter('newFormatTime', function(value) {
    if (value) {
        return moment(String(value)).format('hh:mm a');
    }
});

import VueQuillEditor from 'vue-quill-editor'
 

 
Vue.use(VueQuillEditor, /* { default global options } */)

// global components
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('pagination', pagination);
Vue.component('table-search',TableSearch)

Vue.component('bar-chart',BarChart);
Vue.component('column-chart',ColumnChart);
Vue.component('pie-chart',PieChart);

Vue.component('Table',Table)

// Vue.component('chart', Echarts);
Vue.component('v-select', vSelect)


Vue.prototype.$_ = _;
Vue.prototype.$user = window.Laravel.user;
Vue.prototype.$moment = moment;

new Vue({
	store,
	router,
	render : h => h(App), 
}).$mount('#app');



