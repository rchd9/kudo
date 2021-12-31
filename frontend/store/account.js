import axios from 'axios';

export const state = () => ({
    user: {},
    status: {}
})
    
export const actions = {
    async register({ commit }, payload) {

        //commit('registerRequest');
        return await axios.post(`${process.env.API_URL}/signup`, payload)
            .then( ({ data }) => {
                //commit('setOrder', data);
                //commit('registerSuccess');
                return data;
            })
            .catch(e => {
                //console.log(e);
                //commit('registerFailure');
            });
    },
    async login({ commit }, payload) {

        //commit('registerRequest');
        return await axios.post(`${process.env.API_URL}/login`, payload)
            .then( ({ data }) => {
                //commit('setOrder', data);
                //commit('registerSuccess');
                return data;
            })
            .catch(e => {
                //console.log(e);
                //commit('registerFailure');
            });
    },
    logout({commit}) {
        commit('logout');
    }
}

export const mutations = {
    loginRequest(state, user) {
        state.status = { loggingIn: true };
        state.user = user;
    },
    loginSuccess(state, user) {
        state.status = { loggedIn: true };
        state.user = user;
    },
    loginFailure(state) {
        state.status = {};
        state.user = null;
    },
    logout(state) {
        state.status = {};
        state.user = null;
    },
    registerRequest(state, user) {
        state.status = { registering: true };
    },
    registerSuccess(state, user) {
        state.status = { success: true };
    },
    registerFailure(state, error) {
        state.status = { success: false };
    }
};