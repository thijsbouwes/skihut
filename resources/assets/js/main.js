import Vue from 'vue';
import { store } from './store';
import { router } from './router';
import request from './service/request';
import moment from 'moment';
import M from 'materialize-css';
import App from './App';

Vue.config.productionTip = false;
moment.locale(store.state.time_zone);

Vue.filter('formatNumber', value => {
    let number = parseFloat(value);
    let options = { minimumFractionDigits: 2, style: 'currency', currency: 'EUR' };
    return number.toLocaleString("nl-NL", options);
});

Vue.filter('capitalize', value => {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter('formatDate', value => {
    return moment(value).format(store.state.time_date_format);
});

Vue.prototype.$http = request;
Vue.prototype.$M = M;
Vue.prototype.$moment = moment;

new Vue({
    el: '#app',
    store,
    router,
    render: h => h(App)
});
