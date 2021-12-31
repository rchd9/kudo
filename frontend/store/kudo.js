import axios from 'axios';

export const state = () => ({
    kudos: [],
    kudo: '',
    kudoCards: [],
    kudoTitle: ''
})

export const getters = {
    getKudos(state) {
        return state.kudos;
    },
    getKudo(state) {
        return state.kudo;
    },
    getKudoCards(state) {
        return state.kudoCards;
    },
    getKudoTitle(state) {
        return state.kudoTitle;
    }
}
    
export const actions = {
    async getAllKudos({ commit }, token) {

        return await axios.get(`${process.env.API_URL}/kudos`, { headers: {"Authorization" : `Bearer ${token}`} })
            .then( ({ data }) => {
                commit('setKudos', data.data);
                return data;
            })
            .catch(e => {

            });
    },
    async addKudo({ commit }, obj) {

        return await axios.post(`${process.env.API_URL}/add-kudo`, obj.payload,
        { headers: {"Authorization" : `Bearer ${obj.token}`} })
            .then( ({ data }) => {
                return data;
            })
            .catch(e => {

            });
    },
    async getKudoFromId({ commit }, obj) {

        return await axios.get(`${process.env.API_URL}/kudos/${obj.id}`, { headers: {"Authorization" : `Bearer ${obj.token}`} })
            .then( ({ data }) => {
                commit('setKudo', data.data);
                return data;
            })
            .catch(e => {

            });
    },
    async addCard({ commit }, obj) {

        return await axios.post(`${process.env.API_URL}/add-card`, obj.payload,
        { headers: {"Authorization" : `Bearer ${obj.token}`} })
            .then( ({ data }) => {
                return data;
            })
            .catch(e => {

            });
    },
    async getKudoCardsFromId({ commit }, obj) {

        return await axios.get(`${process.env.API_URL}/kudo-card/${obj.id}`, { headers: {"Authorization" : `Bearer ${obj.token}`} })
            .then( ({ data }) => {
                commit('setKudoCards', data.data.cards);
                commit('setKudoTitle', data.data.title);
                return data;
            })
            .catch(e => {

            });
    },
}

export const mutations = {
    setKudos(state, kudos) {
        state.kudos = kudos;
    },
    setKudo(state, kudos) {
        state.kudo = kudos;
    },
    setKudoCards(state, kudoCards) {
        state.kudoCards = kudoCards;
    },
    setKudoTitle(state, title) {
        state.kudoTitle = title;
    }
};