export default {
    state: {
        isFindUsers: false,
        currUser: {
            index: null,
            userId: null
        },
        users:{
            currentPage: 1,
            countPage:0,
            users: []
        },
        findUsers:{
            findText: '',
            currentPage: 1,
            countPage:0,
            users: []
        }
    },
    getters: {
        getIsFindUsers(state){
            return state.isFindUsers;
        },
        getUsers(state){
            return state.users;
        },
        getFindUsers(state){
            return state.findUsers;
        },
        getCurrUser(state){
           return state.currUser;
        }
    },
    mutations: {
        setFindUsers(state, findUsers){
            state.findUsers  = findUsers;
        },
        setIsFindUsers(state, isFindUsers){
            state.isFindUsers = isFindUsers;
        },
        setUsers(state, users){
            state.users.users = users;
        },
        setUsersCountPage(state, countPage){
            state.users.countPage = countPage;
        },
        setUsersCurrentPage(state, currentPage){
            state.users.currentPage = currentPage
        },
        setCurrUser(state, currUser){
            state.currUser = currUser;
        },
        deleteUser(state, currUserIndex){
            state.users.users.splice(currUserIndex, 1);
        },
        deleteFindUser(state, currUserIndex){
            const findUser = state.findUsers.users[currUserIndex];

            const user = state.users.users.find(user => user.id === findUser.id);
            const indexUser = state.users.users.indexOf(user);

            state.users.users.splice(indexUser, 1);
            state.findUsers.users.splice(currUserIndex, 1);
        }
    },
    actions:{
        setIsFindUsers({ commit }, payload){
            commit('setIsFindUsers', payload)
        },
        setFindUsers({ commit }, findUsers){
            commit('setFindUsers', findUsers)
        },
        setUsers({ commit }, users){
            commit('setUsers', users)
        },
        setUsersCountPage({ commit }, countPage){
            commit('setUsersCountPage', countPage);
        },
        setUsersCurrentPage({ commit }, currentPage){
            commit('setUsersCurrentPage', currentPage);
        },
        setCurrUser({ commit }, currUser){
            commit('setCurrUser', currUser);
        },
        deleteUser({ commit }, currUserIndex){
            commit('deleteUser', currUserIndex);
        },
        deleteFindUser({ commit }, currUserIndex){
            commit('deleteFindUser', currUserIndex);
        }
    }
}
