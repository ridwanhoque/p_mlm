<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Create Product</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <router-link :to="{ name: 'products.index' }" exact class="btn btn-primary">Back</router-link>
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
                                    <label for="brand_id">Brand Name</label>
                                    <select :class="{'is-invalid': errors.hasOwnProperty('brand_id')}" name="brand_id" id="brand_id" class="form-control">
                                        <option value="">Select brand</option>
                                        <option v-for="brand in brands" :value="brand.id">{{ brand.name }}</option>
                                    </select>
                                    <ErrorMessage error-key="brand_id" :errors="errors"/>
                                </div>
                                <div class="form-group">
                                    <label for="description">Product Description</label>
                                    <textarea :class="{'is-invalid': errors.hasOwnProperty('description')}" class="form-control" rows="5" name="description" id="description"></textarea>
                                    <ErrorMessage error-key="description" :errors="errors"/>
                                </div>
                                <div class="form-group">
                                    <label for="origin">Product Origin</label>
                                    <input :class="{'is-invalid': errors.hasOwnProperty('origin')}" type="text" class="form-control" name="origin" id="origin">
                                    <ErrorMessage error-key="origin" :errors="errors"/>
                                </div>
                                <div class="form-group">
                                    <label for="source">Source</label>
                                    <input type="text" class="form-control" name="source" id="source">
                                </div>
                                <div class="form-group">
                                    <label for="supplier_id">Supplier Name</label>
                                    <select :class="{'is-invalid': errors.hasOwnProperty('supplier_id')}" class="form-control" name="supplier_id" id="supplier_id">
                                        <option value="">Select supplier name</option>
                                        <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.name }}</option>
                                    </select>
                                    <ErrorMessage error-key="supplier_id" :errors="errors"/>
                                </div>
                                <CreateCategoryTree/>
                                <div class="form-group">
                                    <label for="purchase_price">Purchase Price</label>
                                    <input :class="{'is-invalid': errors.hasOwnProperty('purchase_price')}" type="text" v-selected v-model.number="product.price.purchase" name="purchase_price" id="purchase_price" class="form-control">
                                    <ErrorMessage error-key="purchase_price" :errors="errors"/>
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
                                    <label for="discount_start_date">Discount Start Date</label>
                                    <Datepicker name="discount_start_date" id="discount_start_date"/>
                                </div>
                                <div class="form-group">
                                    <label for="discount_end_date">Discount End Date</label>
                                    <Datepicker name="discount_end_date" id="discount_end_date"/>
                                </div>
                                <div class="form-group">
                                    <label for="price_after_discount">Price After Discount</label>
                                    <input type="text" :value="priceAfterDiscount" readonly name="price_after_discount" id="price_after_discount" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="commission">Commission</label>
                                    <input type="text" v-selected id="commission" v-model="product.commission" name="commission" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="gross_profit">Gross Profit</label>
                                    <input type="text" :value="grossProfit" readonly name="gross_profit" id="gross_profit" class="form-control">
                                </div>

                                <EmiCreate :errors="errors" :cash-price="grossProfit"/>

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
                                <div class="form-group">
                                    <label for="return_time">Return Time</label>
                                    <input type="text" class="form-control" name="return_time" id="return_time">
                                </div>
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
                                    <label for="images">Product Images</label>
                                    <input accept="image/*" multiple :class="{'is-invalid': errors.hasOwnProperty('images')}" type="file" class="form-control form-control-sm" name="images[]" id="images">
                                    <ErrorMessage error-key="images" :errors="errors"/>
                                    <p class="text-muted">Image size (600x600)px</p>
                                </div>
                                <div class="form-group">
                                    <label for="is_publish">Publish Status</label>
                                    <select name="is_publish" id="is_publish" class="form-control">
                                        <option value="1">Publish</option>
                                        <option value="0">Un Publish</option>
                                    </select>
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
    import CreateCategoryTree from '../../components/create-category-tree'
    import VueSelect from 'vue-select'
    import EmiCreate from '../../components/emi-create'

    export default {
        data(){
            return {
                errors: {},
                brands: [],
                suppliers: [],
                deliveryModes: [],
                product: {
                    price: {
                        purchase: 0,
                        sale: 0,
                    },
                    commission: 0,
                    discountPercent: 0,
                    availableEmi: false,
                    deliveryModes: []
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
            },
            grossProfit(){
                return (this.priceAfterDiscount - this.product.price.purchase - this.product.commission)
            }
        },
        components: {
            ErrorMessage, Datepicker, VueSelect,
            ProgressBar, CreateCategoryTree, EmiCreate
        },
        mounted(){
            this.getBrands()
            this.getSuppliers()

            this.getDeliveryModes()
        },
        methods: {
            getBrands(){
                window.axios.get('/brands?all').then(({ data }) => {
                    this.brands = data.data;
                })
            },
            getSuppliers(){
                window.axios.get('/suppliers').then(({ data }) => {
                    this.suppliers = data.data
                })
            },
            getDeliveryModes(){
                window.axios.get('/delivery-modes').then(({ data }) => this.deliveryModes = data.data)
            },
            create({ target }){
                let vm = this
                window.axios.post('/products', new FormData(target), {
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
            }
        }
    }
</script>