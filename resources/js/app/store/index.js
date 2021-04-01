import Vue from 'vue';
import Vuex from 'vuex';
import user from './modules/user';
import navigatorLinks from './modules/navigator-links';
import messenger from './modules/messenger';
import loaderBar from './modules/loader-bar';
import config from './modules/config';

Vue.use(Vuex);

const store = new Vuex.Store({
        modules: {
            user,
            navigatorLinks,
            messenger,
            loaderBar,
            config
        }
    });

export default store;
