<template>
    <div>
        <a v-if="!confirm" @click.prevent="toggle()" href="#" class="btn btn-xs btn-danger">
            Удалить
        </a>
        <div  class="alert alert-warning" v-else>
            <p>Вы уверены что хотите удалить элемент?</p>
            <a href="#" class="btn btn-xs btn-danger" @click.prevent="confirmed()">Да</a>
            <a href="#" class="btn btn-xs btn-success"  @click.prevent="toggle()">Нет</a>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            confirm: false,
        }
    },
    methods:{
        confirmed(){
            this.$emit('confirm')
        },
        toggle(){
            this.confirm = !this.confirm
        }
    }
}
</script>