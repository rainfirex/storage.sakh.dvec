<template>
    <div class="find-user mt-2 mb-4">
        <div v-if="!isShow" class="text-center">
            <button class="btn btn-second" @click="isShow = !isShow">Поиск на сервере</button>
        </div>
        <div v-else>
            <form @submit.prevent="find">
                <div class="row form-group">
                    <div class="col-md-4 offset-1">
                        <label>Имя пользователя</label>
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" v-model="findUser" placeholder="ФИО" :disabled="isLoading" @keypress.enter="find">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-secondary" :disabled="isLoading">
                            <i class="fa fa-search" aria-hidden="true"> Найти</i>
                        </button>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4 offset-1">
                        <label v-if="count > 0">Найденные пользователи ({{count}})</label>
                        <label v-else>Найденные пользователи</label>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" v-model="indexUser" @change="onchange" :disabled="isLoading">
                            <option v-for="(usr, index) in users" :key="index" :value="index">{{ usr.username }}</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    export default {
        name: "FindUserInAD",
        data(){
            return {
                isShow: false,
                findUser: '',
                indexUser: {},
                users: [],
                count: 0,

                isLoading: false
            }
        },
        methods: {
            ...mapActions(['setMessenger', 'setLoaderBar']),
            find(){
                if (this.findUser.length < 3) return;
                const url = `/api/auth/find/${ this.findUser }`;
                this.indexUser = {};
                this.isLoading = true;
                this.setLoaderBar(true);
                axios.get(url)
                    .then(response => {
                        if (response.data.success) {
                            this.users = response.data.users;
                            this.count = response.data.count;
                        }
                    })
                    .catch(e => {
                        this.errors = e.response.data.message;
                        this.setMessenger({text: this.errors, status: 'error'});
                    })
                    .finally(() => {
                        this.isLoading = false;
                        this.setLoaderBar(false);
                    });
            },
            onchange() {
                this.$emit('user', this.users[this.indexUser]);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .find-user{
        border-bottom: solid 1px black;
    }
</style>
