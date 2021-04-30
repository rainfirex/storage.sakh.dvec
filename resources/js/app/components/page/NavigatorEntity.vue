<template>
    <div class="navigator-entity">
        <ul>
            <li v-for="nav in navigatorEntity">
                <router-link :to="nav.path" active-class="active">
                    <i class="fa" :class="nav.ico" aria-hidden="true"> {{ nav.title }}</i>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "NavigatorEntity",
        computed: {
            navigatorEntity() {
                return this.$store.getters.getEntityNavs;
            },
        }
    }
</script>

<style lang="scss" scoped>
    .navigator-entity{
        ul{
            padding: 5px;
            margin: 0;
            li{
                background: #3c3c3c;
                border-bottom: solid 1px #676767;
                &:last-child{
                    border-bottom: none;
                }
                a{
                    text-decoration: none;
                    display: block;
                    padding: 10px;
                    color: #bfbfbf;
                    transition: 0.5s;
                    &:hover{
                        color: #f3f3f3;
                    }
                }
            }
        }
    }
</style>
