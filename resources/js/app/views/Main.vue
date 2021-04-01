<template>
    <div class="content">
        <div>
            <h2 class="text-center">Главная страница</h2>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Main",
        computed:{
            getUser() {
                return this.$store.getters.getUser;
            },
        },
        mounted() {

            this.$router.push({name: 'entity.users'});

            if (!this.getUser.auth) {
                this.$router.push('/auth');
            }
        }
    }
</script>

<style scoped>

</style>
