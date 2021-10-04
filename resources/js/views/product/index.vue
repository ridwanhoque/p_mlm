<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Products</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <router-link :to="{name: 'products.create'}" class="btn btn-primary">Create</router-link>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <div class="tile-body" v-if="!isEmpty(productData)">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Name</th>
                                <th>Supplier</th>
                                <th>Brand</th>
                                <th>Publish</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(product, index) in productData.data">
                                <td>{{ product.id }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.supplier.name }}</td>
                                <td>{{ product.brand.name }}</td>
                                <td>
                                    <span class="badge p-1" :class="`badge-${product.publish.class}`">{{ product.publish.text }}</span>
                                </td>
                                <td>
                                    <router-link class="btn btn-primary btn-xs" :to="{ name: 'products.update', params: { slug: product.slug } }">
                                        <i class="fa fa-pencil"></i>
                                    </router-link>
                                    <button v-tooltip="'Delete It'" class="btn btn-danger btn-xs" @click="willDelete(product.routes.destroy, () => productData.data.splice(index, 1))">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <Paginator :data="productData" @change-page="getProducts"></Paginator>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Modal from '../../components/modal'
    import ErrorMessage from '../../components/error-message'
    import Paginator from '../../components/paginator'

    export default {
        data(){
            return {
                errors: {},
                productData: {}
            }
        },
        components: {
            Modal, ErrorMessage, Paginator
        },
        mounted(){
            this.getProducts()
        },
        methods: {
            getProducts(page = 1){
                window.axios.get(`/products`, {
                    params: {
                        page
                    }
                }).then(({ data }) => {
                    this.productData = data
                })
            }
        }
    }
</script>