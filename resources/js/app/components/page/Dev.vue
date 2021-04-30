<template>
        <div class="info-block" @click="isClick = !isClick">
            <div class="info-container" v-show="isClick">
                <h3 class="text-center">Разработчик</h3>
                <p>Поплавский А. А. Почта для связи:
                    <a href="mailto:rainfire491@gmail.com">rainfire491@gmail.com</a>
                    <br>
                    <a href="mailto:Poplavskiy-AA@sakh.dvec.ru">Poplavskiy-AA@sakh.dvec.ru</a>
                </p>
            </div>
        </div>
</template>
<script>
    export default {
        name: "Developer",
        data(){
            return {
                isClick: false
            }
        }
    }
</script>
<style lang="scss" scoped>
    .info-block {
        z-index: 999999;
        background: url('/img/info.png') no-repeat center;
        background-size: cover;
        position: fixed;
        right: 10px;
        bottom: 10px;
        width: 50px;
        height: 50px;
        cursor: pointer;
        .info-container{
            padding: 20px;
            position: fixed;
            top: 40%;
            border: solid 2px #ffffff96;
            color: white;
            background: #3c3c3cf5;
            margin: auto;
            left: 40%;
            right: 25%;
            box-shadow: 1px 1px 10px black;
            overflow: hidden;
        }
    }
</style>
