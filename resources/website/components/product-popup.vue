<template>
    <div>
        <div class="popup1" v-show="hasProduct">
            <div class="quick-view-box">
                <img src="/images/close-icon.png" @click.prevent="$store.commit('resetProduct')" alt="close" class="x">
                <div class="product-view product-essential container">
                    <div class="row">
                        <form action="" method="post" id="product_addtocart_form">
                            <div class="product-img-box col-sm-6 col-xs-12">
                                <div class="product-image">
                                    <ProductZoomer v-if="hasProduct" :base-images="previewImages" :base-zoomer-options="galleryConfig"></ProductZoomer>
                                </div>
                                <!-- end: more-images -->
                            </div>
                            <!--End For version 1,2,6-->
                            <!-- For version 3 -->
                            <div class="product-shop col-sm-6 col-xs-12" v-if="hasProduct">
                                <div class="product-name">
                                    <h1 itemprop="name">{{ product.name }}</h1>
                                </div>

                                <div class="price-block">
                                    <div class="price-box">
                                        <span class="regular-price" id="product-price-123"> <span class="price">৳{{ product.price | format}}</span> </span>
                                    </div>
                                    <p class="availability in-stock">
                                        <link itemprop="availability" href="http://schema.org/InStock">
                                        <span>In stock</span>
                                    </p>
                                </div>
                                <!--price-block-->
                                <div class="short-description">
                                    <h2>Quick Overview</h2>
                                    <p>{{ product.description.substring(0, 200) }}</p>
                                </div>
                                <single-add-to-cart class-name="Product" :product-id="product.id"></single-add-to-cart>
                                <!--add-to-box-->
                                <!-- thm-mart Social Share-->
                                <div class="social">
                                    <ul class="link">
                                        <li class="fb">
                                            <a href="http://www.facebook.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                        </li>
                                        <li class="linkedin">
                                            <a href="http://www.linkedin.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                        </li>
                                        <li class="tw">
                                            <a href="http://twitter.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                        </li>
                                        <li class="pintrest">
                                            <a href="http://pinterest.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                        </li>
                                        <li class="googleplus">
                                            <a href="https://plus.google.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- thm-mart Social Share Close-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="hasProduct" id="fade"></div>
    </div>
</template>

<script>
    import { mapGetters, mapState } from 'vuex'

    export default {
        computed: {
            ...mapGetters([
                'hasProduct', 'galleryConfig', 'previewImages'
            ]),
            ...mapState([
                'product'
            ])
        },
    }
</script>