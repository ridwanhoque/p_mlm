<template>
    <div class="cart-collaterals container" v-if="!isCartEmpty">
        <div class="col-md-8">
            <div class="totals">
                <h3>Shipping Address</h3>
                <label for="shipping_address">Address</label>
                <div class="input-box">
                    <textarea v-model="shipping_address" rows="4" id="shipping_address" class="input-text w-100"></textarea>
                    <p class="text-danger" v-if="errors.hasOwnProperty('shipping_address')">{{ errors.shipping_address[0] }}</p>
                </div>
            </div>

        </div>
        <!--col-sm-4-->
        <div class="col-sm-4">
            <div class="totals">
                <h3>Shopping Cart Total</h3>
                <div class="inner">
                    <table id="shopping-cart-totals-table" class="table shopping-cart-table-total">
                        <tfoot>
                        <tr>
                            <td class="a-left" colspan="1">
                                <strong>Grand Total</strong>
                            </td>
                            <td class="a-right">
                                <strong>
                                    <span class="price">৳{{ cart.total | format }}</span>
                                </strong>
                            </td>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr>
                            <td class="a-left" colspan="2">
                                <select v-model="district" type="text" class="input-text w-100">
                                    <option disabled value="">Select district</option>
                                    <option v-for="(district) in districts" :value="district.id">{{ district.name }}</option>
                                </select>
                                <p class="text-danger" v-if="errors.hasOwnProperty('district_id')">{{ errors.district_id[0] }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="a-left" colspan="1">
                                Subtotal
                            </td>
                            <td class="a-right">
                                <span class="price">৳{{ cart.subtotal | format }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="a-left" colspan="1">
                                Delivery Charge
                            </td>
                            <td class="a-right">
                                <span class="price">৳{{ cart.total - cart.subtotal | format }}</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <ul class="checkout">
                        <li>
                            <button @click.prevent="placeOrder" type="button" :disabled="isLoading" title="Place Order" class="button btn-proceed-checkout">
                                <span>{{ isLoading ? 'Loading...' : 'Place Order'}}</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <!--inner-->
            </div>
            <!--totals-->
        </div>
        <!--col-sm-4-->
    </div>
</template>

<script>
    import Cart from "../service/Cart";
    import { mapState, mapGetters } from 'vuex'

    export default {
        data(){
            return {
                district: '',
                districts: [],
                shipping_address: '',
                isLoading: false,
                errors: {}
            }
        },
        computed: {
            ...mapState([
                'cart'
            ]),
            ...mapGetters([
                'isCartEmpty'
            ]),
            isOutSideDhaka(){
                if(!this.district){
                    return false;
                }
                return Boolean(this.districts.filter((d) => d.id === this.district)[0].is_outside_dhaka)
            },
        },
        watch: {
            district(id){
                Cart.setDistrict(id)
            }
        },
        mounted() {
            window.axios.get('/shipping-address').then(({ data }) => {
                this.districts = data.districts;
                this.shipping_address = data.shipping_address
            })
        },
        methods: {
            placeOrder(){
                if(this.isLoading){
                    return;
                }

                this.isLoading = true

                window.axios.post('/portal/orders', {
                    district_id: this.district,
                    shipping_address: this.shipping_address
                }).then(({ data }) => {
                    swal(data.message, {
                        icon: 'success'
                    })

                    this.$store.commit('clearProduct')

                    this.errors = {}
                }).catch(({ response }) => {
                    if(response.status === 422){
                        this.errors = response.data.errors;
                        return;
                    }

                    swal(response.data.message, {
                        icon: 'error'
                    })

                }).then(() => {
                    this.isLoading = false
                })
            }
        }
    }
</script>