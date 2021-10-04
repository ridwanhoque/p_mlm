import Vue from 'vue'
import Vuex from 'vuex'
import _ from 'lodash'
import pluralize from 'pluralize'
import Cart from "./service/Cart";
import Product from "./service/Product";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        cart: {
            content: {},
            total: 0,
            subtotal: 0
        },
        product: {},
        gallery: {
            config: {
                'zoomFactor': 3,
                'pane': 'pane', // three type of pane ['pane', 'container-round', 'container']
                'hoverDelay': 100, // how long after the zoomer take effect
                'namespace': 'product-zoomer', // add a namespace for zoomer component, useful when on page have mutiple zoomer
                'move_by_click':true, // move image by click thumb image or by mouseover
                'scroll_items': 5, // thumbs for scroll
                'choosed_thumb_border_color': "#fdd922", // cheesed thumb border color
                'move_button_style': 'chevron'
            }
        }
    },
    actions: {
        removeCartItem({state}, id){
            Cart.remove(id);
        },

        // Product

        getProduct(context, slug){
            Product.get(slug).then(({ data }) => {
                this.commit('setProduct', data.data)
            })
        }
    },
    mutations: {
        cart(state, cart){
            state.cart = cart
        },
        addToCart(state, data){
            if(!_.isEmpty(state.product)){
                this.commit('resetProduct')
            }

            if(_.isEmpty(state.cart.content)){
                return
            }

            Vue.set(state.cart.content, data.item.id, data.item)

            this.commit('setCartTotal', data.total)

            this.commit('setSubtotal', data.subtotal)
        },
        setCartTotal(state, total){
            state.cart.total = total
        },
        setSubtotal(state, subtotal){
            state.cart.subtotal = subtotal
        },
        removeCartItem(state, { id, total, subtotal }){

            Vue.delete(state.cart.content, id);

            this.commit('setCartTotal', total)

            this.commit('setSubtotal', subtotal)
        },

        // Product

        resetProduct(state){
            state.product = {};
        },
        setProduct(state, product){
            state.product = product
        },
        clearProduct(state){
            state.cart = {
                content: {},
                total: 0,
                subtotal: 0
            }
        }
    },
    getters: {
        isCartEmpty(state){

            return _.isEmpty(state.cart.content)
        },
        cartItem(state){
            return `${Object.keys(state.cart.content).length} ${pluralize("Item", Object.keys(state.cart.content).length)}`;
        },

        // Product Section

        hasProduct(state){
            return !_.isEmpty(state.product)
        },

        previewImages(state){
            if(!state.product.images){
                return {}
            }

            return {
                normal_size: state.product.images.map((image) => {
                    return {
                        id: image.id,
                        url: '/uploads/' + image.path
                    }
                })
            }
        },

        galleryConfig(state){
            return state.gallery.config;
        }
    }
})