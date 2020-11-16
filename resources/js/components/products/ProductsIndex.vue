<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createProduct'}" class="btn btn-success">Добавить товар</router-link> 
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="product-filter">Поиск по названию</span>
            </div>
            <input type="text" class="form-control" 
                placeholder="введите название..." aria-label="Product name" aria-describedby="product-filter"
                v-model="productNameFilter"
            >
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" @click="productNameFilter=''">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Список товаров</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Стоимость</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in currentPageProducts" :key="product.id">
                            <td>{{ product.name }}</td>
                            <td>{{ product.price }}</td>
                            <td>
                                <router-link :to="{name: 'editProduct', params: {id: product.id}}" class="btn btn-xs btn-primary">
                                    Редактировать
                                </router-link>
                                
                                <confirm v-on:confirm="deleteEntry(product.id)"></confirm>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="panel-footer">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#" @click.prevent="changePagePrevious()">Назад</a></li>
                        <li :class="'page-item '+(page==currentPage?'active':'')" v-for="page in pages">
                            <a class="page-link" href="#" @click.prevent="changePage(page)">{{page}}</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#" @click.prevent="changePageNext()">Вперед</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
 
<script>
    import Confirm from '../Confirm.vue';
    export default {
        data () {
            return {
                products: [],
                currentPage: 1,
                pageItemsCount: 5,
                productNameFilter: '',
            }
        },
        components: {Confirm},
        computed: {
            lastPage() {
                return Math.ceil(this.filteredProducts.length / this.pageItemsCount)
            },
            pages(){
                return Array.from(Array(this.lastPage), (_,x) => x+1)
            },
            filteredProducts(){
                return this.products.filter((item,_) => 
                    item.name.includes(this.productNameFilter)
                )
            },
            currentPageProducts(){
                return this.filteredProducts.filter((_,index) => 
                    ((index >= (this.currentPage-1)*this.pageItemsCount) && 
                    (index < this.currentPage*this.pageItemsCount))
                )
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/products')
                .then(function (resp) {
                    app.products = resp.data
                })
                .catch(function (resp) {
                    console.log(resp)
                    alert("Could not load products")
                });
        },
        methods: {
            changePage(page){
                this.currentPage = page
            },
            changePageNext(){
                if(this.currentPage < this.lastPage) {
                    this.currentPage++
                }
            },
            changePagePrevious(){
                if(this.currentPage > 1) {
                    this.currentPage--
                }
            },
            async deleteEntry(id) {
                try {
                    let resp = await axios.delete('/api/v1/products/' + id)
                    this.products = this.products.filter(item => item.id !== id)
                } catch(error) {
                    console.log(error)
                    alert("Could not delete product")
                }
            }
        }
    }
</script>