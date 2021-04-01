export default {
    state: {
        loaderBar: false,
    },
    getters: {
        getLoaderBar(state){
            return state.loaderBar;
        }
    },
    mutations: {
        setLoaderBar(state, payload) {
            if (payload === true) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }

            state.loaderBar = payload
        },
    },
    actions: {
        setLoaderBar({ commit }, payload) {
            commit('setLoaderBar', payload)
        },
    }
}
