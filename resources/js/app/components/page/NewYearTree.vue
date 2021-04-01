<template>
        <div class="new-year-tree" @click="isClick = !isClick">
            <div class="new-year-container" v-show="isClick">
                <h3 class="text-center">С новым годом!</h3>
                <p>Пусть наступающий Новый год станет для всех нас годом новых открытий и свершений.</p>
            </div>
        </div>
</template>

<script>
    export default {
        name: "NewYearTree",
        data(){
            return {
                isClick: false
            }
        }
    }
</script>

<style lang="scss" scoped>
    .new-year-tree {
        background: url('/img/tree.png') no-repeat center;
        background-size: cover;
        position: fixed;
        right: 20px;
        bottom: 10px;
        width: 100px;
        height: 200px;
        cursor: pointer;
        .new-year-container{
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
        }
    }
</style>
