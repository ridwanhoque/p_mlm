<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-shopping-cart"></i> Purchase</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <button data-toggle="modal" data-target=".create-modal" class="btn btn-primary">Purchase</button>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <app-loader></app-loader>
                        <table class="table-bordered table" v-if="!isEmpty(purchaseData)">
                            <thead>
                            <tr>
                                <th>Purchase ID</th>
                                <th>Supplier</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(purchase, index) in purchaseData.data">
                                    <td>{{ purchase.id }}</td>
                                    <td>{{ purchase.supplier.name }}</td>
                                    <td>{{ purchase.total.formatted() }}</td>
                                    <td>{{ purchase.paid.formatted() }}</td>
                                    <td>{{ purchase.due.formatted() }}</td>
                                    <td>
                                        <router-link class="btn btn-primary btn-xs" title="Payment History" :to="{ name: 'purchase.payment.index', params: { purchase: purchase.id} }">
                                            <i class="fa fa-retweet"></i>
                                        </router-link>
                                        <button class="btn btn-danger btn-xs" title="Delete" @click="willDelete(purchase.routes.destroy, () => purchaseData.data.splice(index, 1))">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Paginator @change-page="getPurchases" :data="purchaseData"></Paginator>
                    </div>
                </div>
            </div>
        </div>

        <Modal modal-class="create-modal" title="Make Purchase" modal-dialog-class="modal-lg">
            <form @submit.prevent="create">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <select name="supplier_id" :class="{'is-invalid': errors.hasOwnProperty('supplier_id')}" id="supplier" class="form-control">
                                <option value="">Select supplier</option>
                                <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.name }}</option>
                            </select>
                            <ErrorMessage :errors="errors" error-key="supplier_id"/>
                        </div>
                    </div>
                </div>
                <div class="row" v-for="(product, index) in products">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" :name="`products[${index}][product_id]`" :value="product.product.id">
                            <label :for="`product-${index}`">Product</label>
                            <VueSelect @search="searchProducts" v-model="product.product" label="name" :options="productData" :id="`product-${index}`"></VueSelect>
                            <ErrorMessage error-class="text-danger" :errors="errors" :error-key="`products.${index}.product_id`"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label :for="`quantity-${index}`">Quantity</label>
                            <input type="text" :class="{'is-invalid': errors.hasOwnProperty(`products.${index}.quantity`)}" v-selected v-model.number="product.quantity" class="form-control" :name="`products[${index}][quantity]`" :id="`quantity-${index}`">
                            <ErrorMessage :errors="errors" :error-key="`products.${index}.quantity`"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label :for="`price-${index}`">Price</label>
                            <input type="text" :class="{'is-invalid': errors.hasOwnProperty(`products.${index}.price`)}" v-selected v-model.number="product.price" class="form-control" :name="`products[${index}][price]`" :id="`price-${index}`">
                            <ErrorMessage :errors="errors" :error-key="`products.${index}.price`"/>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button v-if="products.length === (index + 1)" @click="addProduct()" class="btn btn-primary btn-xs">Add More</button>
                        <button v-if="index" @click="products.splice(index, 1)" class="btn btn-danger btn-xs">Remove</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 offset-md-8 mt-2">
                        <div class="form-group">
                            <label for="subtotal">Subtotal</label>
                            <input type="text" :value="subtotal" readonly id="subtotal" name="subtotal" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="paid">Paid</label>
                            <input type="text" :class="{'is-invalid': errors.hasOwnProperty('paid')}" v-selected v-model.number="paid" id="paid" name="paid" class="form-control">
                            <ErrorMessage :errors="errors" error-key="paid"/>
                        </div>
                        <div class="form-group">
                            <label for="due">Due</label>
                            <input type="text" :value="subtotal - paid" readonly id="due" name="due" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Purchase</button>
                        </div>
                    </div>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script>
    import ErrorMessage from '../../components/error-message'
    import VueSelect from 'vue-select'
    import Modal from '../../components/modal.vue'
    import _ from 'lodash'
    import Supplier from '../../services/Supplier'
    import Purchase from "../../services/Purchase";
    import Paginator from '../../components/paginator'

    export default {
        data(){
            return {
                errors: {},
                products: [],
                suppliers: [],
                productData: [],
                paid: 0,
                purchaseData: {}
            }
        },
        components: {
            ErrorMessage, VueSelect, Modal, Paginator
        },
        computed: {
            subtotal(){
                return this.products.reduce((carray, product) => {
                    return (carray + (product.quantity * product.price))
                }, 0)
            }
        },
        mounted(){
            Supplier.get().then(({ data }) => {
                this.suppliers = data.data
            })
            this.addProduct()
            this.getPurchases()
        },
        methods: {
            searchProducts: _.debounce(function (search, loading) {
                loading(true)

                window.axios.get('/products', {
                    params: {
                        query: search
                    }
                }).then(({ data }) => {
                    this.productData = data.data
                }).then(() => {
                    loading(false)
                })
            }, 500),

            create({ target }){
                Purchase.store(target).then(() => {
                    this.errors = {}
                    $('.create-modal').modal('hide')
                    this.getPurchases()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            addProduct(){
                this.products.push({
                    product: {},
                    quantity: 0,
                    price: 0
                })
            },

            getPurchases(page = 1){
                Purchase.get({ page }).then(({ data }) => {
                    this.purchaseData = data
                })
            }
        }
    }
</script>