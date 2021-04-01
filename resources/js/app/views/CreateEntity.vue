<template>
    <div class="content">

        <div class="text-center mb-2 p-2">
            <h3>Новый пользователь</h3>
        </div>

        <div class="offset-2 col-8">
            <FindUserInAD @user="setUser($event)"></FindUserInAD>
        </div>

        <form>
            <div class="text-center mb-3">
                <button class="btn btn-info" @click.prevent="save">Сохранить пользователя</button>
            </div>

            <div class="columns">
                <div class="data main">
                    <div class="offset-1 mb-2 p-2">
                        <h4>Пользователь</h4>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Полное имя</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.username" ref="username">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.username)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Логин</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.login" ref="login">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.login)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Электронный адрес</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.email" ref="email">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.email)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Отдел</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.department" ref="department">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.department)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Должность</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.title" ref="title">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.title)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Телефон</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.phone" ref="phone">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.phone)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Мобильный телефон</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.mobile" ref="mobile">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.mobile)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Дополнительный телефон</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.othertelephone" ref="othertelephone">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.othertelephone)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="data other">
                    <div class="offset-1 mb-2 p-2">
                        <h4>Местонахождение</h4>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Город</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.city" ref="city">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.city)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Улица, дом</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.street" ref="street">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.street)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Кабинет</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="user.cabinet" ref="cabinet">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.cabinet)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="offset-1 mb-2 p-2">
                        <h4>Компьютеры</h4>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Компьютеры пользователя ({{ user.computers.length }})</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-danger" title="Убрать компьютер" @click.prevent="removeComputer">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <select class="form-control" v-model="selectComp">
                                    <option v-for="(comp, index) in user.computers" :key="index" :value="comp">{{ comp.hostname }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" title="Добавить компьютер" @click.prevent="addComputer">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Операционная система</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="selectComp.operatingsystem" ref="operatingsystem">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.operatingsystem)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Service pack</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="selectComp.servicepack" ref="servicepack">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.servicepack)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>IP-адрес</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="selectComp.ipAddress" ref="ipAddress">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.ipAddress)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4 offset-1">
                            <label>Host</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="selectComp.hostname" ref="hostname">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyFieldBuffer($refs.hostname)">
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <Passwords :passwords="passwords" @updatePasswords="passwords = $event"></Passwords>

        </form>
    </div>
</template>

<script>
    import FindUserInAD from "../components/FindUserInAD";
    import { mapActions } from 'vuex';
    import Passwords from "../components/Passwords";

    export default {
        name: "CreateEntity",
        components:{
            FindUserInAD,
            Passwords
        },
        computed:{
            getUser() {
                return this.$store.getters.getUser;
            },
        },
        mounted() {
            if (!this.getUser.auth) {
                this.$router.push('/auth');
            }
        },
        data(){
            return {
                isLoading: false,
                user: {
                    username: '',
                    login: '',
                    email: '',
                    department: '',
                    title: '',
                    phone: '',
                    othertelephone: '',
                    mobile: '',
                    company: '',
                    city: '',
                    street: '',
                    cabinet: '',

                    computers: []
                },
                passwords: [],
                selectComp: {}
            }
        },
        methods: {
            ...mapActions(['setMessenger', 'setLoaderBar']),
            setUser(user){
                this.user = user;
            },
            addComputer(){
                const count =   this.user.computers.length + 1;
                const tmpComp = {operatingsystem: '', servicepack: '', ipAddress: '', hostname: 'Компьютер'+count};
                this.user.computers.push(tmpComp);
                this.selectComp = tmpComp;
            },
            removeComputer(){

                const index = this.user.computers.indexOf(this.selectComp);

                if (index !== -1){

                    if (!confirm(`Вы собираетесь удалить этот компьютер. Выполнить это действие?`))
                        return;

                    this.user.computers.splice(index, 1);
                }
            },
            copyFieldBuffer(input) {
                input.select();
                document.execCommand('copy');
            },
            save() {
                const url = `/api/entity/users`;

                const frmData = new FormData();
                frmData.append('username', this.user.username);
                frmData.append('login', this.user.login);
                frmData.append('email', this.user.email);
                frmData.append('department', this.user.department);
                frmData.append('title', this.user.title);
                frmData.append('phone', this.user.phone);
                frmData.append('othertelephone', this.user.othertelephone);
                frmData.append('mobile', this.user.mobile);
                frmData.append('city', this.user.city);
                frmData.append('street', this.user.street);
                frmData.append('cabinet', this.user.cabinet);
                frmData.append('passwords', JSON.stringify(this.passwords));
                frmData.append('computers', JSON.stringify(this.user.computers));

                this.isLoading = true;
                this.setLoaderBar(true);

                axios.post(url, frmData)
                    .then(response => {
                        if (response.data.success){
                            this.setMessenger({text: 'Запиь создана.', status: 'success'});
                            this.resetData();
                        } else {
                            this.setMessenger({text: response.data.message, status: 'error'});
                        }
                    })
                    .catch(e => {
                        this.errors = e.response.data.message;
                        this.setMessenger({text: this.errors, status: 'error'});
                    })
                    .finally(() => {
                        this.isLoading = false;
                        this.setLoaderBar(false);
                    })
            },
            resetData(){
                this.user = {
                    username: '',
                    login: '',
                    email: '',
                    department: '',
                    title: '',
                    phone: '',
                    othertelephone: '',
                    mobile: '',
                    company: '',
                    city: '',
                    street: '',
                    cabinet: '',

                    computers: []
                };

                this.passwords = [];

                this.selectComp = {}
            }
        }
    }
</script>

<style lang="scss" scoped>
    .columns{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;

        .data{
            width: 670px;

            &.main{
                /*border-right: solid 1px #c5c5c5;*/
            }
        }
    }
    .password-board{
        background-color: white;
    }
</style>
