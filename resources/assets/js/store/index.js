import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    time_format: 'HH:mm:ss',
    date_format: 'DD-MM-YYYY',
    time_date_format: 'DD-MM-YYYY - HH:mm:ss',
    time_zone: 'nl',
};

export const store = new Vuex.Store({
    state,
    modules: {
    }
});