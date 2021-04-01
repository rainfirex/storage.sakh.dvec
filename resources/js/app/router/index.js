import VueRouter from 'vue-router';
import Main from '../views/Main.vue';
import CreateEntity from "../views/CreateEntity.vue";
import EditEntity from "../views/EditEntity.vue";
import ListUser from "../views/ListUser.vue";
import Auth from '../views/Auth.vue';
import NotFound from '../views/404.vue';

// const Products = { template: '<div><h1>Товары</h1><router-view></router-view></div>' };
// const Phones = { template: '<h2>Смартфоны</h2>' };
// const Tablets = { template: '<h2>Планшеты</h2>' };

export default new VueRouter({
    routes : [
        {
            path: '/', component: Main, name: 'main'
        },
        {
            path: '/auth', component: Auth, name: 'auth',
            children: [
                {
                    path: 'logout',
                    component: Auth,
                    name: 'auth.logout'
                }
            ]
        },
        {
            path: '/entity/users', component: ListUser, name: 'entity.users'
        },
        {
            path: '/entity/users/create', component: CreateEntity, name: 'create'
        },
        {
            path: '/entity/users/:id/edit', component: EditEntity, name: 'edit'
        },
        {
            path: '*', component: NotFound, name: 'not-found', meta: {
                requestAuth: false
            }
        },
        // {
        //     path: '/products', component: Products,
        //     children:[
        //         {
        //             path: 'phones', component: Phones
        //         },
        //         {
        //             path: 'tablets', component: Tablets
        //         }
        //     ]
        // }
    ], mode : 'history'
});
