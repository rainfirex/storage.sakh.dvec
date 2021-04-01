export default {
    state: {
        user: {
            login: false,
            user_id: null,
            api_token: null,
            name: null,
            email: null,
            phone: null,
            mobile: null,
            department: null,
            title: null,
            is_handler: null
        }
    },

    getters: {
        getUser(state) {
            return state.user;
        }
    },

    mutations: {
        setUser(state, payload) {
            state.user = payload;
        }
    },

    actions: {
        setUser({ commit }, payload) {
            commit('setUser', payload)
        }
    }
}
