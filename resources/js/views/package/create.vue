<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-pagelines"></i> Create Package</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <router-link :to="{ name: 'packages.index' }" exact class="btn btn-primary">Back</router-link>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <form @submit.prevent="create">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input required type="text" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name">
                                    <ErrorMessage error-key="name" :errors="errors"/>
                                </div>

                                <div class="form-group">
                                    <label>Products</label>
                                    <VueSelect label="name" :options="products" @search="getProducts" multiple v-model="product.products" ></VueSelect>
                                    <ErrorMessage error-key="product_id" :errors="errors"/>
                                    <input type="hidden" name="products[]" v-for="pro in product.products" :value="pro.id">
                                </div>

                                <div class="form-group">
                                    <label for="sale_price">Sale Price</label>
                                    <input :class="{'is-invalid': errors.hasOwnProperty('sale_price')}" type="text" v-selected v-model.number="product.price.sale" name="sale_price" id="sale_price" class="form-control">
                                    <ErrorMessage error-key="sale_price" :errors="errors"/>
                                </div>
                                <div class="form-group">
                                    <label for="discount">Discount %</label>
                                    <input type="text" v-selected v-model.number="product.discountPercent" name="discount_percentage" id="discount" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="discount_amount">Discount Given</label>
                                    <input type="text" :value="discountGiven" readonly name="discount_amount" id="discount_amount" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="price_after_discount">Price After Discount</label>
                                    <input type="text" :value="priceAfterDiscount" readonly name="price_after_discount" id="price_after_discount" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="discount_start_date">Discount Start Date</label>
                                    <Datepicker name="discount_start_date" id="discount_start_date"/>
                                </div>
                                <div class="form-group">
                                    <label for="discount_end_date">Discount End Date</label>
                                    <Datepicker name="discount_end_date" id="discount_end_date"/>
                                </div>

                                <div class="form-group">
                                    <label for="commission">Commission</label>
                                    <input type="text" v-selected id="commission" name="commission" class="form-control" value="0">
                                </div>

                                <EmiCreate :errors="errors" :cash-price="priceAfterDiscount"/>

                                <div class="form-group">
                                    <label for="delivery_mode">Delivery Mode</label>
                                    <VueSelect id="delivery_mode" v-model="product.deliveryModes" multiple label="name" :options="deliveryModes"></VueSelect>
                                    <input type="hidden" name="delivery_modes[]" v-for="mode in product.deliveryModes" :value="mode.id">
                                    <p class="text-danger" v-if="errors.hasOwnProperty('delivery_modes')">{{ errors.delivery_modes[0] }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="a_delivery_charge_dhaka">Additional Delivery Charge (Dhaka)</label>
                                    <input type="text" value="0" class="form-control" name="a_delivery_charge_dhaka" id="a_delivery_charge_dhaka">
                                </div>
                                <div class="form-group">
                                    <label for="a_delivery_charge_out_of_dhaka">Additional Delivery Charge (Out of Dhaka)</label>
                                    <input type="text" value="0" class="form-control" name="a_delivery_charge_out_of_dhaka" id="a_delivery_charge_out_of_dhaka">
                                </div>
                                <div class="form-group">
                                    <label for="delivery_time_dhaka">Delivery Time (Dhaka)</label>
                                    <input type="text" class="form-control" name="delivery_time_dhaka" id="delivery_time_dhaka">
                                </div>
                                <div class="form-group">
                                    <label for="delivery_time_out_of_dhaka">Delivery Time (Out Of Dhaka)</label>
                                    <input type="text" class="form-control" name="delivery_time_out_of_dhaka" id="delivery_time_out_of_dhaka">
                                </div>

                                <CreateCategoryTree/>

                                <div class="form-group">
                                    <label for="priority">Priority</label>
                                    <input type="text" value="1" class="form-control" name="priority" id="priority">
                                </div>
                                <div class="form-group">
                                    <label for="comments">Comments</label>
                                    <textarea class="form-control" rows="5" name="comments" id="comments"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="cash_back">Cash Back</label>
                                    <textarea class="form-control" rows="5" name="cash_back" id="cash_back"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="nb">NB:</label>
                                    <textarea class="form-control" rows="5" name="nb" id="nb"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="position">Post To</label>
                                    <select name="position" id="position" class="form-control">
                                        <option value="1">Ony Front</option>
                                        <option value="2">Only Back</option>
                                        <option value="3">Both</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="images">Package Images</label>
                                    <input accept="image/*" multiple :class="{'is-invalid': errors.hasOwnProperty('images')}" type="file" class="form-control form-control-sm" name="images[]" id="images">
                                    <ErrorMessage error-key="images" :errors="errors"/>
                                    <p class="text-muted">Image Size (620x325)px</p>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="show_on_home" value="1" class="custom-control-input" id="show_on_home">
                                        <label class="custom-control-label" for="show_on_home">Is Show On Homepage</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="publish_at" value="1" class="custom-control-input" id="publish_at">
                                        <label class="custom-control-label" for="publish_at">Is Publish</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="mt-2">
                                            <ProgressBar :percentage="percentage"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from '../../components/datepicker'
    import ErrorMessage from '../../components/error-message'
    import ProgressBar from '../../components/progress-bar'
    import EmiCreate from '../../components/emi-create'
    import CreateCategoryTree from '../../components/create-category-tree'
    import VueSelect from 'vue-select'
    import _ from 'lodash'

    export default {
        data(){
            return {
                errors: {},
                deliveryModes: [],
                products: [],
                product: {
                    price: {
                        sale: 0,
                    },
                    discountPercent: 0,
                    deliveryModes: [],
                    products: []
                },
                percentage: 0
            }
        },
        computed: {
            discountGiven(){
                return Math.round(
                    this.product.price.sale.percentOf(this.product.discountPercent)
                )
            },
            priceAfterDiscount(){
                return (this.product.price.sale - this.discountGiven)
            }
        },
        components: {
            ErrorMessage, Datepicker, VueSelect, ProgressBar, CreateCategoryTree, EmiCreate
        },
        mounted(){
            this.getDeliveryModes()
        },
        methods: {
            getDeliveryModes(){
                window.axios.get('/delivery-modes').then(({ data }) => this.deliveryModes = data.data)
            },
            create({ target }){
                let vm = this
                window.axios.post('/packages', new FormData(target), {
                    onUploadProgress(event){
                        if(event.lengthComputable){
                            vm.percentage = Math.round(event.loaded * 100 / event.total)
                        }
                    }
                }).then(() => {
                    this.percentage = 0
                    this.errors = {}
                    target.reset()
                }).catch(({ response }) => {
                    if(response.status == 422){
                        this.errors = response.data.errors
                    }
                    this.percentage = 0
                })
            },
            getProducts: _.debounce(function (search, loading) {
                loading(true)

                window.axios.get(`/products`, {
                    params: {
                        query: search
                    }
                }).then(({ data }) => {
                    this.products = data.data

                    loading(false)
                })
            }, 500)
        }
    }
</script>