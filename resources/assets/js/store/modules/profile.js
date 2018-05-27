import request from '../../service/request';
import { Event } from '../../service/event';
import * as types from '../mutation-types';
import { ENDPOINTS } from '../../config/api';

// initial state
const state = {
    user: {
        id: null,
        name: '',
        email: '',
        events: [],
        is_admin: false,
        created_at: null
    },
    changed: false,
    loading: true
};

// getters
const getters = {
    user: state => state.user,
    is_admin: state => state.user.is_admin
};

// actions
const actions = {
    loadProfile({ commit }) {

        return request.get(ENDPOINTS.USER)
            .then(response => {
                commit(types.SET_PROFILE, response.data);
                commit(types.LOADING_DONE);

                Event.$emit('PROFILE_LOADED');
            });
    }
};

// mutations
const mutations = {
    [types.SET_PROFILE] (state, user) {
        state.user = user;
    },

    [types.LOADING_DONE] (state) {
        state.loading = false;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}