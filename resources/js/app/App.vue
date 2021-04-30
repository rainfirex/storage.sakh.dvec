<template>
    <div class="wrapper">
        <Header></Header>
        <div class="wrapper__content">
            <aside>
                <div class="test">
                    <NavigatorEntity></NavigatorEntity>
                </div>
                <div class="test-2">
                    <NavigatorAuth></NavigatorAuth>
                </div>
            </aside>
            <section>
                <router-view></router-view>
            </section>
        </div>
        <LoaderBar></LoaderBar>
        <Messenger></Messenger>
        <NewYearTree/>
    </div>
</template>
<script>
    import Header from "./components/page/Header";
    import NavigatorEntity from "./components/page/NavigatorEntity";
    import NavigatorAuth from "./components/page/NavigatorAuth";
    import Messenger from "./components/Messenger";
    import User from "./assets/js/User";
    import LoaderBar from "./components/LoaderBar";
    import NewYearTree from './components/page/Dev.vue'
    export default {
        name: "App",
        components: {
            Header,
            NavigatorEntity,
            NavigatorAuth,
            Messenger,
            LoaderBar,
            NewYearTree
        },
        created() {
            User.init();
        }
    }
</script>
<style lang="scss" scoped>
    .wrapper__content{
        display: flex;
        min-height: 100%;
        aside{
            /*background: linear-gradient(45deg, black, #424242);*/
            background: linear-gradient(45deg, #000000f0, #424242e6);
            width: 20%;
            max-width: 250px;
            position: relative;
        }
        section{
            width: 100%;
        }
    }
    .test{
        width: 100%;
        position: sticky;
        top: 15px;
    }
    .test-2{
        position: sticky;
        top: 94%;
        left: 0;
        right: 0;
    }
</style>
