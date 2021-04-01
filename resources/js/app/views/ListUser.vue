<template>
    <div class="content">

        <div class="text-center mb-2 p-2">
            <h3>Пользователи</h3>
        </div>

        <div class="d-flex flex-md-nowrap flex-sm-wrap">
            <Pagination :countPage="currentCountPage" :currentPage="currentPage" @getUsers="loadUsers"/>
            <FindUser ref="finder"/>
        </div>

        <div class="table-responsive">
            <ContextMenu v-show="contextMenu" ref="cxtMenu" @cxtMethod="cxtMethod"/>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Полное имя</th>
                        <th scope="col">Почта</th>
                        <th scope="col">Должность</th>
                        <th scope="col">Отдел</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in currentUsers" @dblclick.prevent="edit(user.id)" @click.prevent="active(index, user.id)"
                        :class="{'active': index === currUserIndex && user.id === currUserId}" style="cursor: pointer" @contextmenu.prevent @contextmenu.right="showContextMenu($event, index, user.id)">
                        <td>{{ user.username }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.title }}</td>
                        <td>{{ user.department }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import Pagination from "../components/Pagination";
    import FindUser from "../components/FindUser";
    import ContextMenu from "../components/ContextMenu";
    export default {
        name: "ListUser",
        components:{
            Pagination,
            FindUser,
            ContextMenu
        },
        computed:{
            ...mapGetters([
                'getIsFindUsers', 'getUsers', 'getFindUsers', 'getCurrUser'
            ]),
            getUser() {
                return this.$store.getters.getUser;
            },
            currentUsers(){
                if(this.getIsFindUsers)
                    return this.getFindUsers.users;
                else{
                    return this.getUsers.users;
                }
            },
            currentCountPage(){
                if(this.getIsFindUsers)
                    return this.getFindUsers.countPage;
                else
                    return this.getUsers.countPage;
            },
            currentPage(){
                if(this.getIsFindUsers)
                    return this.getFindUsers.currentPage;
                else
                    return this.getUsers.currentPage;
            },
            currUserIndex(){
                return this.getCurrUser.index;
            },
            currUserId(){
                return this.getCurrUser.userId;
            }
        },
        data(){
            return {
                isLoading: false,
                contextMenu: false
            }
        },
        mounted(){
            if (!this.getUser.auth) {
                this.$router.push('/auth');
            } else {
                if(!this.getIsFindUsers)
                    this.getPages();

                this.loadUsers();
            }
        },
        methods: {
            ...mapActions([
                'setLoaderBar', 'setMessenger', 'setIsFindUsers',
                'setFindUsers', 'setCurrUser',
                'setUsers', 'setUsersCountPage', 'setUsersCurrentPage',
                'deleteUser', 'deleteFindUser'
            ]),
            getPages(){
                const url = `/api/entity/users/count-page`;

                this.isLoading = true;
                this.setLoaderBar(true);
                axios.get(url)
                    .then(response => {
                        this.setUsersCountPage( response.data.countPages);
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
            loadUsers(numPage){
                if (this.getIsFindUsers){
                    this.$refs.finder.setPage(numPage);
                    this.$refs.finder.find();
                    return;
                }

                if (numPage) this.setUsersCurrentPage(numPage);

                const url = `/api/entity/users/page-${this.getUsers.currentPage}`;

                this.isLoading = true;
                this.setLoaderBar(true);

                axios.get(url)
                    .then(response => {
                        if (response.data.success){
                            this.setUsers(response.data.users);
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
            edit(id){
                this.$router.push({name: 'edit', params: {id: id}});
            },
            active(index, userId){
                this.contextMenu = false;
                    this.setCurrUser({
                    index,
                    userId
                });
            },
            showContextMenu(event, index, userId){

                this.active(index, userId);

                if (this.currUserIndex === index){
                    this.contextMenu = !this.contextMenu;

                    const posX = event.clientX;
                    const posY = event.clientY;

                    this.$refs.cxtMenu.$el.style.left = (posX - 90)+ 'px';
                    this.$refs.cxtMenu.$el.style.top = (posY - 20) + 'px';
                }
            },
            cxtMethod(method){
                this.contextMenu = !this.contextMenu;
                switch (method) {
                    case 'edit':
                        this.edit(this.currUserId);
                        break;
                    case 'create':
                        this.$router.push({name: 'create'});
                        break;
                    case 'remove':
                        this.remove();
                        break;
                }
            },
            remove(){
                const url = `/api/entity/users/${ this.currUserId }`;

                this.isLoading = true;
                this.setLoaderBar(true);

                axios.delete(url)
                    .then(response => {
                        if (response.data.success){

                            if(!this.getIsFindUsers)
                                this.deleteUser(this.currUserIndex);
                             else
                                this.deleteFindUser(this.currUserIndex);

                            this.setMessenger({text: 'Запись удалена.', status: 'success'});
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
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>
    tr {
        transition: 0.2s;
        &:hover{
            /*background-color: #dedede;*/
        }
        &.active{
            background: #738998 !important;
            color: #fff !important;
        }
    }
</style>
