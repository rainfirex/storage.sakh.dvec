export default {
    state: {
        entity: [
            // {path: '/', title: 'Главная страница', auth: 'both', ico: 'fa-home'},
            {path: '/entity/users',        title: 'Пользователи', auth: true, ico: 'fa-users'},
            {path: '/entity/users/create', title: 'Новый пользователь',  auth: true, ico: 'fa-user-plus'}
        ],
        auth: [
            {path: '/auth', title: 'Авторизация', auth: false, ico: 'fa-user'},
            {path: '/auth/logout', title: 'Выход', auth: true}
        ]
    },

    getters: {
        getEntityNavs(state) {
            return state.entity;
        },
        getAuthNavs(state){
            return state.auth;
        }
    },

    mutations: {
    },

    actions: {
    }
}
