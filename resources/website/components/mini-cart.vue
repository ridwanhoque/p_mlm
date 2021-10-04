<template>
    <div class="mini-cart" @mouseenter="getCartProducts">
        <div class="basket">
            <a href="/cart"></a>
        </div>
        <div class="fl-mini-cart-content">
            <template v-if="!$store.getters.isCartEmpty">
                <div class="block-subtitle">
                    <div class="top-subtotal">{{ $store.getters.cartItem }}, <span class="price">৳{{ $store.state.cart.total | format }}</span> </div>
                    <!--top-subtotal-->
                    <!--pull-right-->
                </div>
                <!--block-subtitle-->
                <ul class="mini-products-list" id="cart-sidebar">
                    <li class="item first" v-for="item in $store.state.cart.content">
                        <div class="item-inner">
                            <a class="product-image" :title="item.name" :href="item.attributes.permalink">
                                <img :alt="item.name" :src="item.attributes.photo">
                            </a>
                            <div class="product-details">
                                <div class="access">
                                    <a @click.prevent="$store.dispatch('removeCartItem', item.id)" class="btn-remove1" title="Remove This Item" href="#">Remove</a>
                                </div>
                                <!-- access -->
                                <strong>{{ item.quantity }}</strong> x <span class="price">৳{{ item.price | format }}</span>
                                <p class="product-name">
                                    <a :href="item.attributes.permalink">{{ item.name }}</a>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="actions">
                    <a href="/cart" class="view-cart" title="View Cart"><span>View Cart</span></a>
                </div>
                <!--actions-->
            </template>
            <ul class="mini-products-list" v-else>
                <li class="item first">
                    <p>Your cart is empty!</p>
                </li>
            </ul>
        </div>
        <!--fl-mini-cart-content-->
    </div>
</template>

<script>
    import Cart from "../service/Cart";

    export default {
        data(){
            return {
                isProcessing: false,
            }
        },
        methods: {
            getCartProducts(){
                if(this.isProcessing || ! this.$store.getters.isCartEmpty){
                    return;
                }
                this.isProcessing = true;

                Cart.getProducts().then(() => {
                    this.isProcessing = false
                })
            }
        }
    }
</script>