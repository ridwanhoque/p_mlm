<template>
    <div class="add-to-box">
        <div class="add-to-cart">
            <div class="pull-left">
                <div class="custom pull-left">
                    <button @click="quantity++" class="increase items-count" type="button"><i class="icon-plus"></i></button>
                    <input type="text" v-model="quantity" id="qty" min="1" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                    <button @click="quantity > 1 ? quantity-- : null" class="reduced items-count" type="button"><i class="icon-minus"></i></button>
                </div>
                <!--custom pull-left-->
            </div>
            <!--pull-left-->
            <button type="button" @click.prevent="addToCart" title="Add to Cart" class="button btn-cart">
                <span>Add to Cart</span>
            </button>
            <button v-if="isEmi" type="button" @click.prevent="buyWithEmi" title="Buy with EMI" class="button btn-cart">
                <span>Buy With Emi</span>
            </button>
        </div>
        <!--add-to-cart-->
        <div class="email-addto-box">
            <ul class="add-to-links">
                <li>
                    <a class="link-wishlist" @click.prevent="addToWishlist" title="Add To Wishlist"><span>Add To Wishlist</span></a>
                </li>
            </ul>
            <!--add-to-links-->
        </div>
        <!--email-addto-box-->
    </div>
</template>

<script>
    import Cart from "../service/Cart";
    import Wishlist from "../service/Wishlist";

    export default {
        props: {
            productId: [String, Number],
            className: String,
            isEmi: {
                default: false,
                type: Boolean
            }
        },
        data(){
            return {
                quantity: 1
            }
        },
        methods: {
            addToCart(){
                Cart.addToCart({
                    id: `${this.className}_${this.productId}`,
                    quantity: this.quantity
                })
            },
            addToWishlist(){
                Wishlist.store(this.productId, this.className)
            },
            buyWithEmi(){
                Cart.addToCart({
                    id: `${this.className}_${this.productId}`,
                    quantity: this.quantity,
                    emi: true,
                })
            }
        }
    }
</script>