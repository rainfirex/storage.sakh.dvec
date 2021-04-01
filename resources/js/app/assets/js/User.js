import store from "../../store";

export default {
    init() {
        store.commit('setUser', this.loadUser());
    },

    loadUser() {
        const user = {};
        user.user_id   = localStorage.getItem('user_id');
        user.api_token = localStorage.getItem('api_token');
        user.name      = localStorage.getItem('name');
        user.email     = localStorage.getItem('email');
        user.phone     = localStorage.getItem('phone');
        user.mobile    = localStorage.getItem('mobile');
        user.department = localStorage.getItem('department');
        user.title      = localStorage.getItem('title');
        user.is_handler = (localStorage.getItem('is_handler') == 'true') ? true : false;
        user.auth =
            user.user_id !== null &&
            user.api_token !== null &&
            user.name !== null;

        //Токен авторизации api
        const token = user.api_token;
        const auth  = user.auth;

        if (token && auth) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        }

        return user;
    },

    login(user){
        localStorage.setItem('user_id', user.user_id);
        localStorage.setItem('api_token', user.api_token);
        localStorage.setItem('name', user.name);
        localStorage.setItem('email', user.email);
        localStorage.setItem('phone', user.phone);
        localStorage.setItem('mobile', user.mobile);
        localStorage.setItem('department', user.department);
        localStorage.setItem('title', user.title);
        localStorage.setItem('is_handler', user.is_handler);
        localStorage.setItem('last_ip', user.last_ip);
        localStorage.setItem('user_agent', user.user_agent);
    },

    logout() {
        localStorage.removeItem('user_id');
        localStorage.removeItem('api_token');
        localStorage.removeItem('name');
        localStorage.removeItem('email');
        localStorage.removeItem('phone');
        localStorage.removeItem('mobile');
        localStorage.removeItem('department');
        localStorage.removeItem('title');
        localStorage.removeItem('is_handler');
        localStorage.removeItem('last_ip');
        localStorage.removeItem('user_agent');
    }
}
