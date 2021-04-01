<template>
    <div class="content" v-if="!isUrlLogout">
        <div class="offset-1 col-10 offset-md-2 col-md-8">
            <h2 class="text-center">Авторизация</h2>
            <hr>
            <div class="form-group">
                <label for="user">Пользователь</label>
                <input type="text" class="form-control" id="user" aria-describedby="userHelp" v-model="login"
                       :class="{'error-input': $v.login.$error}">
                <small id="userHelp" class="form-text text-muted" :class="{'is-error': $v.login.$error}">Введите логин.
                    <span v-if="!$v.login.required" class="error-text" :class="{'error-show': !$v.login.required}">Поле пустое</span>
                </small>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" aria-describedby="passwordHelp"
                       v-model="password" :class="{'error-input': $v.password.$error}">
                <small id="passwordHelp" class="form-text text-muted" :class="{'is-error': $v.password.$error}">Введите
                    пароль.
                    <span v-if="!$v.password.required" class="error-text"
                          :class="{'error-show': !$v.password.required}">Поле пустое</span>
                    <span v-if="!$v.password.minLength" class="error-text"
                          :class="{'error-show': !$v.password.minLength}">Минимум 8 символа</span></small>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-outline-dark" @click="auth">Войти</button>
            </div>
        </div>
    </div>
</template>

<script>
    import User from "../assets/js/User";
    import { mapActions } from 'vuex';
    import { required, minLength } from 'vuelidate/lib/validators'
    export default {
        name: "Auth",
        computed: {
            getUser() {
                return this.$store.getters.getUser;
            },
            isUrlLogout() {
                return this.$route.fullPath === '/auth/logout';
            }
        },
        data() {
            return{
                login: '',

                password:'',

                errors: []
            }
        },
        validations: {
            login: {
                required
            },

            password: {
                required,
                minLength: minLength(8)
            }
        },
        methods: {
            ...mapActions(['setMessenger']),

            auth() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    this.setMessenger({text: 'Заполните все поля!', status: 'error'});
                    return false;
                }

                const url = `/api/auth/login`;
                axios.post(url, {login: this.login, password: this.password}).then(response => {
                    if (response.data.success) {
                        User.login(response.data);
                        User.init();

                        this.setMessenger({text: 'Вы вошли в систему', status: 'success'});
                        this.$router.push('/');

                    } else {
                        this.setMessenger({text: response.data.message, status: 'error'});
                    }

                }).catch(error => {
                    this.errors = error.response.data.message;
                    this.setMessenger({text: this.errors, status: 'error'});
                });
            },

            logout() {
                const url = `/api/auth/logout`;
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.getUser.api_token;
                axios.post(url).then(response => {
                    if (response.data.success) {

                        this.setMessenger({text: 'Вы вышли из системы', status: 'success'});

                        if (this.$router.history.current.path !== '/') {
                            this.$router.push({name: 'auth'});
                        }
                    } else {
                        this.setMessenger({text: response.data.message, status: 'error'});
                    }
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    this.setMessenger({text: this.errors, status: 'error'});

                    if (error.response.data.message === 'Unauthenticated.') {
                        this.$router.push('/');
                    }

                }).finally(() => {
                    User.logout();
                    User.init();
                });
            },

            listenerKeyDown(e) {
                if(e.code === 'Enter' && e.key === 'Enter') {
                    this.auth();
                }

                if (e.code === 'Escape' && e.key === 'Escape') {
                    if (this.login.length > 0 || this.password.length > 0) {
                        if(confirm('Сбросить поля ввода?')) {
                            this.login = '';
                            this.password = '';
                        }
                    }
                }
            }
        },
        created() {
          if(this.isUrlLogout) {
              this.logout();
          }
        },
        mounted() {
            document.body.addEventListener('keydown', this.listenerKeyDown);
        },
        beforeDestroy() {
            document.body.removeEventListener('keydown', this.listenerKeyDown);
        }
    }
</script>

<style lang="scss" scoped>

</style>
