export default {
    state: {
        messenger: {
            text: '',
            status: '',
            timerId: null,
            timeout: 8500
        }
    },
    getters: {
        getMessenger(state) {
            return state.messenger;
        }
    },
    mutations: {
        setMessenger(state, payload) {

            state.messenger.text = payload.text;
            state.messenger.status = payload.status;

            if (state.messenger.timerId)
                clearTimeout(state.messenger.timerId);

            state.messenger.timerId = setTimeout(() => {
                if (state.messenger.text.length > 1) {
                    state.messenger.text = '';
                }

            }, state.messenger.timeout);
        },
        clearTimeoutMessenger(state) {
            clearInterval(state.messenger.timerId);
        }
    },
    actions: {
        setMessenger({ commit }, payload) {
            commit('setMessenger', payload)
        },
        clearTimeoutMessenger({commit, getters}) {
            if (getters.getMessenger.timerId){
                commit('clearTimeoutMessenger');
            }
        }
    }
}
