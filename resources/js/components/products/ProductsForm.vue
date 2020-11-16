<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Create new product</div>
            <div class="panel-body">
                <form @submit.prevent="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Product name</label>
                            <input type="text" v-model="product.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Product price</label>
                            <input type="text" v-model="product.price" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Create</button>
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
                product: {
                    name: '',
                    price: '',
                }
            }
        },
        computed: {
            formTypeEdit(){
                return this.productId !== null
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
                } catch (resp) {
                    console.log(resp);
                    alert("Could not create product");
                }
            }
        }
    }
</script>