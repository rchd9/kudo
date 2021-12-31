const cookieparser = process.server ? require('cookieparser') : undefined;

export const state = () => ({
    session: {
        token: null,
        user: {},
        loggedIn: false
    }
})

export const actions = {
    async nuxtServerInit ({ commit, dispatch }, { req }) {
        let session = null
        if (req.headers.cookie) {
            const parsed = cookieparser.parse(req.headers.cookie)
            try {
                session = JSON.parse(parsed.session)
                console.log('session', session);
            } catch (err) {
                // No valid cookie found
            }
        }
        commit('setSession', session);
    }
}


export const mutations = {
    setSession (state, data) {
        if(data != null) {
            state.session = data
        }
    }
}


