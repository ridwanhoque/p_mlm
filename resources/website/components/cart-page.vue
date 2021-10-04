<template>
    <form method="post" @submit.prevent="updateCart">
        <input type="hidden" name="_method" value="PUT">
        <fieldset>
            <table id="shopping-cart-table" class="data-table cart-table table-striped">
                <thead>
                    <tr class="first last">
                        <th rowspan="1">&nbsp;</th>
                        <th rowspan="1"><span class="nobr">Product Name</span></th>
                        <th class="a-center" colspan="1"><span class="nobr">Unit Price</span></th>
                        <th rowspan="1" class="a-center">Qty</th>
                        <th class="a-center" colspan="1">Subtotal</th>
                        <th rowspan="1" class="a-center">&nbsp;</th>
                    </tr>
                </thead>
                <tfoot v-if="!$store.getters.isCartEmpty">
                    <tr class="first last">
                        <td colspan="7" class="last">
                            <button type="button" title="Continue Shopping" class="button btn-continue">
                                <span><span>Continue Shopping</span></span>
                            </button>
                            <button type="submit" name="update_cart_action" value="update_qty" title="Update Cart" class="button btn-update">
                                <span><span>Update Cart</span></span>
                            </button>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="item in $store.state.cart.content">
                        <td class="image hidden-table">
                            <a :href="item.attributes.permalink" :title="item.name" class="product-image">
                                <img :src="item.attributes.photo" width="75" :alt="item.name">
                            </a>
                        </td>
                        <td>
                            <h2 class="product-name">
                                <a :href="item.attributes.permalink">{{ item.name }}</a>
                            </h2>
                        </td>
                        <td class="hidden-table">
                            <span class="cart-price">
                                <span class="price">৳{{ item.price | format }}</span>
                            </span>
                        </td>
                        <td class="a-center movewishlist">
                            <input :name="`product[${item.id}][quantity]`" min="1" :value="item.quantity" size="4" title="Qty" class="input-text qty" maxlength="12">
                            <p class="text-danger" v-if="errors.hasOwnProperty(`product.${item.id}.quantity`)">{{ errors[`product.${item.id}.quantity`][0] }}</p>
                        </td>
                        <td class="movewishlist">
                            <span class="cart-price">
                                <span class="price">৳{{(item.price * item.quantity) | format}}</span>
                            </span>
                        </td>
                        <td class="a-center last">
                            <a href="#" title="Remove item" @click.prevent="$store.dispatch('removeCartItem', item.id)" class="button remove-item"><span><span>Remove item</span></span></a>
                        </td>
                    </tr>
                    <tr v-if="$store.getters.isCartEmpty">
                        <td colspan="6" class="text-center">Your shopping cart is empty!</td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </form>
</template>

<script>
    import Cart from "../service/Cart";

    export default {
        data(){
            return {
                errors: {}
            }
        },
        mounted() {
            Cart.getProducts()
        },
        methods: {
            updateCart({ target }){
                this.errors = {}

                Cart.update(target).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        }
    }
</script>