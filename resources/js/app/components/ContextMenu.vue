<template>
    <div class="context-menu">
        <ul class="p-0 m-0">
            <li><a href="#" @click.prevent="$emit('cxtMethod','edit')"><i class="fa fa-pencil" aria-hidden="true"> Редактировать</i></a></li>
            <li><a href="#" @click.prevent="$emit('cxtMethod','create')"><i class="fa fa-user-plus" aria-hidden="true"> Создать пользователя</i></a></li>
            <li><a href="#" @click.prevent="$emit('cxtMethod','remove')"><i class="fa fa-trash-o" aria-hidden="true"> Удалить</i></a></li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "ContextMenu"
    }
</script>

<style lang="scss" scoped>
.context-menu{
    ul{
        text-decoration: none;
        li{
            padding: 0;
            border-bottom: solid 1px #99a3b5;
            &:last-child{
                border: none;
            }
            a{
                padding: 5px;
                text-decoration: none;
                display: block;
                color: #c0c0c1;
                transition: 0.2s;
                &:hover{
                    color: #fbf5f5;
                    background: #7c8e9e;
                }
            }
        }
    }
    background: #748892;
    color: white;
    position: fixed;
    width: 250px;
    outline: 1px solid #f3efef;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 1px 1px 10px black;
}
</style>
