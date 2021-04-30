<template>
    <div>
        <div class="mb-4 text-center">
            <button class="btn btn-secondary" @click.prevent="addPassword">Добавить пароль</button>
        </div>

        <div v-for="(pas, index) in passwords" class="password-board p-2 m-2">
            <div  class="row form-group">
                <div class="offset-2 col-md-3">
                    <input type="text" class="form-control" v-model="pas.title" placeholder="Краткое описание">
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="password" class="form-control" v-model="pas.password" @click.prevent="showPassword" @blur="hiddenPassword" :ref="'pass'+parseInt(index)" placeholder="Пароль">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" title="Скопировать" @click.prevent="copyPasswordBuffer(index)">
                                <i class="fa fa-files-o" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-danger" @click.prevent="removePassword(index, pas.id)">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
            </div>
            <div class="row form-group">
                <div class="offset-2 col-md-7">
                    <textarea class="form-control" v-model="pas.description" placeholder="Описание"></textarea>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import { mapActions } from 'vuex';
    export default {
        name: "Passwords",
        props:{
            passwords:{
                type:Array,
                default:[]
            }
        },
        data() {
            return {
                isLoading: false
            }
        },
        methods: {
            ...mapActions(['setMessenger', 'setLoaderBar']),
            copyPasswordBuffer(index){
                const el = this.$refs['pass'+index][0];
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
            addPassword() {
                this.passwords.push({title: '', password: '', description: ''});
                this.$emit('updatePasswords', this.passwords);
            }
        }
    }
</script>

<style scoped>

</style>
