<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-primary">Назад</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">{{formText}} товар</div>
            <div class="panel-body">
                <form @submit.prevent="saveForm()">
                    <div class="row" v-if="errorData && errorData.message">
                        <div class="col-xs-12 form-group">
                            <div class="alert alert-danger">
                                {{errorData.message}}
                            </div>
                        </div>
                    </div>
                    <div class="row" v-for="label, fieldName in fields" :key="fieldName">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">{{label}}</label>
                            <div class="alert alert-danger" v-if="errorData && errorData.errors && errorData.errors[fieldName]">
                                {{errorData.errors[fieldName].join(' ')}}  
                            </div>
                            <input type="text" v-model="product[fieldName]" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">{{formText}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                productId: null,
                fields: {
                    name: 'Название товара',
                    price: 'Стоимость товара'
                },
                product: {
                    name: '',
                    price: '',
                },
                errorData: false,
            }
        },
        computed: {
            formTypeEdit(){
                return this.productId !== null
            },
            formText(){
                return this.formTypeEdit?'Изменить':'Добавить';
            }
        },
        mounted() {
            let app = this
            let id = app.$route.params.id
            if(id){
                app.productId = id;
                axios.get('/api/v1/products/' + id)
                    .then(function (resp) {
                        app.product = resp.data
                    })
                    .catch(function () {
                        alert("Could not load your company")
                    });
            }
        },
        methods: {
            saveForm() {
                if (this.formTypeEdit) {
                    this.saveFormEdit()
                } else {
                    this.saveFormCreate()
                }
            },
            async saveFormEdit(){
                try {
                    let resp = await axios.patch('/api/v1/products/' + this.productId, this.product)
                    this.$router.replace('/')
                } catch (resp) {
                    console.log(resp);
                    alert("Could not save product")
                }
            },
            async saveFormCreate() {
                try {
                    let resp = await axios.post('/api/v1/products', this.product)
                    console.log(resp)
                    console.log('created?')
                    this.$router.push('/')
                } catch (err) {
                    if (err.response.status === 422) {
                        this.errorData = {
                            message: 'Форма заполнена некорретно',
                            errors: err.response.data.errors
                        }
                    } else {
                        this.errorData = {
                            message: 'Неизвестная ошибка',
                            errors: []
                        }
                    }
                    // alert("Could not create product");
                }
            }
        }
    }
</script>