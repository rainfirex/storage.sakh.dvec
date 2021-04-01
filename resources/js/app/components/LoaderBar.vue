<template>
    <transition name="fade">
        <div class="loader-bar" v-show="getLoaderBar">
            <div><img src="/img/Loading.gif" alt="loading">Loading...</div>
        </div>
    </transition>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        name: "LoaderBar",

        computed: {
            ...mapGetters(['getLoaderBar'])
        }
    }
</script>

<style lang="scss" scoped>
    .loader-bar{
        color: white;
        background: rgba(21, 22, 22, 0.9);
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: 999;

        display: flex;
        justify-content: center;
        align-items: center;

        user-select: none;
    }

    .loader-bar > div{
        font-size: 1.4em;
        padding: 20px 30px;
        background: #0062cc;
    }

    img {
        width: 40px;
    }

    .fade-enter-active {
        animation: fadeIn .1s ease-in;;
    }

    .fade-leave-active{
        transition: opacity  .1s;
    }

    @keyframes fadeIn{
        0%{
            opacity: 0;
        }
        50%{
            opacity: 0.5;
        }
        100%{
            opacity: 1;
        }
    }
</style>
