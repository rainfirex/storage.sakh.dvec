<template>
    <transition name="ani">
        <div class="messenger mt-4 p-3 offset-1 col-10 offset-md-3 col-md-6"
             v-show="getMessenger.text"
             v-bind:class="{success: getMessenger.status === 'success', error: getMessenger.status === 'error'}"
             @dblclick="close"
             @mouseenter="hover"
             @mouseleave="isHover=false">
            <p class="offset-1 col-10 messenger-text"
               :class="{'is-error': getMessenger.status === 'error', 'is-success': getMessenger.status === 'success'}">{{getMessenger.text}}</p>
            <hr>
            <p class="help m-0 p-0 text-center" @click="close">Нажми чтобы закрыть</p>
        </div>
    </transition>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    export default {
        name: "Messenger",
        data() {
            return {
                isHover : false
            }
        },
        computed: {
            ...mapGetters(['getMessenger'])
        },

        methods: {
            ...mapActions(['setMessenger', 'clearTimeoutMessenger']),

            close() {
                this.isHover = false;
                this.setMessenger({text: ''});
            },

            hover() {
                this.isHover = true;
                this.clearTimeoutMessenger();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .messenger {
        box-shadow: 1px 2px 10px 0.2rem rgba(0, 0, 0, 0.25);
        background-color: #6281a0f7;
        color: white;
        line-height: 40px;
        position: fixed;
        left: 0;
        right: 0;
        bottom: 10px;
        z-index: 99;
        overflow: hidden;
        text-align: justify;

        &:hover {
            background: #5a615b;
            outline: solid 2px #f0f0f0;
        }

        .is-error:before {
            border-left: 25px #ed3737 solid;
        }

        .is-success:before {
            border-left: 25px #1ec90a solid;
        }
    }

    .messenger-text {

        &:before {
            content: "";
            border-radius: 5%;
            margin-right: 15px;
            border: solid;
        }
    }

    .error {
        background-color: #965c64;
    }

    .success {
        background-color: rgb(101, 165, 115);
    }

    .help {
        font-size: 11px;
        cursor: pointer;
    }

    .ani-enter, .ani-leave {
        opacity: 0;
        width: 0;
    }

    .ani-enter-active {
        animation: ani-in 0.6s ease-in;
    }

    .ani-leave-active {
        animation: ani-in 0.3s ease-in reverse;
    }

    @keyframes ani-in {
        0% {
            opacity: 0;
            width: 0;
        }

        50% {
            opacity: 0.5;
            width: 50%;
        }

        100% {
            opacity: 1;
            width: 100%;
        }
    }
</style>
