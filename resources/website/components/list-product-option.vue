<template>
    <div class="actions">
        <button @click.prevent="addToCart" class="button btn-cart ajx-cart" title="Add to Cart" type="button"><span>Add to Cart</span></button>
        <span class="add-to-links" @click.prevent="addToWishlist">
            <a title="Add to Wishlist" class="button link-wishlist" href="#"><span>Add to Wishlist</span></a>
        </span>
    </div>
</template>

<script>
    import Cart from "../service/Cart";
    import Wishlist from "../service/Wishlist";

    export default {
        props: [
            'productId',
            'className',
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