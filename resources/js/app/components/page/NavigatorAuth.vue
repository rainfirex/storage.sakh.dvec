<template>
    <div class="navigator-auth">
        <ul>
            <li v-for="nav in navigatorAuthLogout" v-if="nav.auth === getUser.auth">
                <router-link
                    class="btn btn-secondary"
                    v-if="nav.path === '/auth/logout'"
                    :to="nav.path"><i class="fa fa-home" aria-hidden="true"> {{ nav.title }}</i></router-link>

                <router-link
                    v-else
                    :to="nav.path">{{ nav.title }}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "NavigatorAuth",
        computed: {
            getUser() {
              return this.$store.getters.getUser;
            },
            navigatorAuthLogout() {
                return this.$store.getters.getAuthNavs;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .navigator-auth{
        ul{
            padding: 0;
            margin: 0;

            li{
                text-align: center;
            }
            a{
                padding: 10px;
            }
        }
    }
</style>
