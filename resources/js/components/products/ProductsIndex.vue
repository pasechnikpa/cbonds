<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createProduct'}" class="btn btn-success">Create new product</router-link> 
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="product-filter">Filter</span>
            </div>
            <input type="text" class="form-control" placeholder="name" aria-label="Product name" aria-describedby="product-filter">
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Products list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in currentPageProducts" :key="product.id">
                            <td>{{ product.name }}</td>
                            <td>{{ product.price }}</td>
                            <td>
                                <router-link :to="{name: 'editProduct', params: {id: product.id}}" class="btn btn-xs btn-default">
                                    Edit
                                </router-link>
                                <a href="#"
                                class="btn btn-xs btn-danger"
                                v-on:click="deleteEntry(product.id)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="panel-footer">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#" @click.prevent="changePagePrevious()">Previous</a></li>
                        <li :class="'page-item '+(page==currentPage?'active':'')" v-for="page in pages">
                            <a class="page-link" href="#" @click.prevent="changePage(page)">{{page}}</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#" @click.prevent="changePageNext()">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data: function () {
            return {
                products: [],
                currentPage: 1,
                pageItemsCount: 5,
            }
        },
        computed: {
            lastPage() {
                return Math.ceil(this.products.length / this.pageItemsCount)
            },
            pages(){
                return Array.from(Array(this.lastPage), (_,x) => x+1)
            },
            currentPageProducts(){
                return this.products.filter((_,index) => 
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
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
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
    }
</script>