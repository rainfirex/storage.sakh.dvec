<template>
    <div>
        <div class="mb-4 text-center">
            <button class="btn btn-secondary" @click.prevent="add">Новый пароль</button>
        </div>
        <div class="password-block">
            <table class="table">
                <tr>
                    <th>Краткое описание</th>
                    <th>Пароль</th>
                    <th>Описание</th>
                </tr>
                <tr class="item-pass" v-for="(pas, index) in passwords" :key="pas.id" @dblclick="show(pas)">
                    <td>{{ pas.title }}</td>
                    <td>******</td>
                    <td>{{ pas.description }}</td>
                </tr>
            </table>
            <div class="password-board p-4 m-2" v-if="password">
                <div class="form-group text-center">
                    <p><b>Редактирование - {{ password.title }}</b></p>
                </div>
                <div  class="row form-group">
                    <div class="offset-2 col-md-3">
                        <input type="text" class="form-control" v-model="password.title" placeholder="Краткое описание">
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="password" class="form-control" v-model="password.password" @click.prevent="showPassword" @blur="hiddenPassword" ref="passInput" placeholder="Пароль">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyPasswordBuffer()">
                                    <i class="fa fa-files-o" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger" @click.prevent="removePassword(index, password.id)">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="row form-group">
                    <div class="offset-2 col-md-7">
                        <textarea class="form-control" v-model="password.description" placeholder="Описание"></textarea>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-outline-secondary" @click="password = null">Закрыть</button>
                </div>
            </div>
            <div class="password-board p-4 m-2" v-if="newPassword">
                <div class="form-group text-center">
                    <p><b>Новый пароль</b></p>
                </div>
                <!--Описание и пароль-->
                <div  class="row form-group">
                    <div class="offset-2 col-md-3">
                        <input type="text" class="form-control" v-model="newPassword.title" placeholder="Краткое описание">
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="password" class="form-control" v-model="newPassword.password" @click.prevent="showPassword" @blur="hiddenPassword" ref="passInput" placeholder="Пароль">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyPasswordBuffer()">
                                    <i class="fa fa-files-o" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger" @click.prevent="newPassword = null">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                </div>
                <!--Описание-->
                <div class="row form-group">
                    <div class="offset-2 col-md-7">
                        <textarea class="form-control" v-model="newPassword.description" placeholder="Описание"></textarea>
                    </div>
                </div>
                <!--Кнопки-->
                <div class="text-center">
                    <button class="btn btn-outline-info" @click.prevent="save">Добавить</button>
                    <button class="btn btn-outline-secondary" @click="newPassword = null">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions } from 'vuex';
    export default {
        name: "PasswordsInTable",
        props:{
            passwords:{
                type:Array,
                default:[]
            }
        },
        data() {
            return {
                isLoading: false,
                password: null,
                newPassword: null
            }
        },
        methods: {
            ...mapActions(['setMessenger', 'setLoaderBar']),
            add() {
                this.newPassword = {};
            },
            save() {
                this.passwords.push(this.newPassword);
                this.$emit('updatePasswords', this.passwords);
                this.newPassword = null;
            },
            show(pas, index) {
                this.password = pas;
            },
            copyPasswordBuffer(){
                const el = this.$refs.passInput;
                el.type = 'text';
                el.select();
                document.execCommand('copy');
            },
            removePassword(index, id){
                if (!confirm(`Вы собираетесь удалить пароль. Выполнить это действие?`))
                    return;

                if (id) {
                    const url = `/api/entity/passwords/${ id }`;
                    this.isLoading = true;
                    this.setLoaderBar(true);

                    axios.delete(url)
                        .then(response => {
                            if (response.data.success){
                                this.passwords.splice(index, 1);
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
                } else
                    this.passwords.splice(index, 1);
            },
            showPassword($event){
                $event.target.type = 'text';
            },
            hiddenPassword($event) {
                $event.target.type = 'password';
            },
        }
    }
</script>
<style lang="scss" scoped>
    .table {
        .item-pass {
            cursor: pointer;
            &:hover {
                background: #9facb3;
            }
        }
    }
    .password-block{
        min-height: 500px;
        max-height: 1000px;
        overflow: auto;
        border: solid 1px #495057;
        .password-board{
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            z-index: 55;
            width: 100%;
            max-width: 700px;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -100px !important;
            margin-left: -250px !important;
            background: #f5f5f5;
            border-radius: 4px;
        }
    }
</style>
