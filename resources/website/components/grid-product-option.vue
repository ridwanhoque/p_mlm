<template>
    <div class="box-inner">
<!--        <div class="product-detail-bnt" @click.prevent="$store.dispatch('getProduct', slug)">-->
<!--&lt;!&ndash;            <a class="button detail-bnt"><span>Quick View</span></a>&ndash;&gt;-->
<!--        </div>-->
<!--        <div class="actions">-->
<!--            <span class="add-to-links">-->
<!--                <a @click.prevent="addToWishlist" href="#" class="link-wishlist" title="Add to Wishlist">-->
<!--                    <span>Add to Wishlist</span>-->
<!--                </a>-->
<!--            </span>-->
<!--        </div>-->
        <div class="add_cart">
            <button @click.prevent="addToCart" class="button btn-cart" type="button"><span>Add to Cart</span></button>
        </div>
    </div>
</template>

<script>
    import Cart from "../service/Cart";
    import Wishlist from "../service/Wishlist";

    export default {
        props: [
            'productId',
            'className',
            'slug'
        ],
        methods: {
            addToCart(){
                Cart.addToCart({
                    id: `${this.className}_${this.productId}`,
                    quantity: 1
                });
            },
            addToWishlist(){
                Wishlist.store(this.productId, this.className)
            }
        }
    }
</script>