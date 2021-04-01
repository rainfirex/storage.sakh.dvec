<template>
    <div class="col-12 col-md-8">
        <div class="row form-group">
            <div class="col-md-6 input-group">
                <input type="text" class="form-control" v-model="findText" placeholder="ФИО" :disabled="isLoading" ref="findInput" @keypress.enter="find">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" title="Очистить" @click.prevent="clearText">
                        <i class="fa fa-eraser" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <button class="btn btn-secondary" :disabled="isLoading" @click="find" title="Искать"><i class="fa fa-search" aria-hidden="true"> Найти</i></button>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    export default {
        name: "FindUser",
        data(){
            return{
                isLoading: false,
                currentPage: 1,
                findText: '' //александ
            }
        },
        computed:{
            ...mapGetters(['getFindUsers'])
        },
        methods:{
            ...mapActions(['setMessenger', 'setLoaderBar', 'setFindCurrentPage', 'setIsFindUsers', 'setFindUsers']),
            clearText() {
                this.findText = '';
                this.$refs.findInput.focus();
                this.setIsFindUsers(false);
                this.setFindUsers({
                    findText: '',
                    currentPage: 1 ,
                    countPage: 0,
                    users: []
                });
            },
            setPage(numPage){
                if(numPage) this.currentPage = numPage;
                else this.currentPage = this.getFindUsers.currentPage;
                this.findText = this.getFindUsers.findText;
            },
            find(){

                if(this.findText.length <= 1) return;

                this.isLoading = true;
                this.setLoaderBar(true);
                const url = `/api/entity/users/find/${ this.findText }/page-${ this.currentPage }`;

                axios.get(url)
                    .then(response => {
                        const {users, countPages} = response.data;

                        this.setIsFindUsers(true);
                        this.setFindUsers({
                            findText: this.findText,
                            currentPage: this.currentPage,
                            countPage: countPages,
                            users: users
                        });
                    })
                    .catch(e => {
                        this.errors = e.response.data.message;
                        this.setMessenger({text: this.errors, status: 'error'});
                    })
                    .finally(() => {
                        this.isLoading = false;
                        this.setLoaderBar(false);
                    });
            }
        }
    }
</script>
