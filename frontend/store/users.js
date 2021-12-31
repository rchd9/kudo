import axios from 'axios';

export const state = () => ({
    users: []
})

export const getters = {
    getUsers(state) {
        return state.users;
    }
}
    
export const actions = {
    async getAllUsers({ commit }, tokenStr) {

        return await axios.get(`${process.env.API_URL}/users`, { headers: {"Authorization" : `Bearer ${tokenStr}`} })
            .then( ({ data }) => {
                if (data.success) {
                    console.log('vuex', data.data);
                    commit('setUsers', data.data);
                }
            })
            .catch(e => {

            });
    }
}

export const mutations = {
    setUsers(state, users) {
        state.users = users;
    },
};