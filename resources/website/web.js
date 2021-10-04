import Vue from 'vue'
import store from './store'
import axios from 'axios'
import numeral from 'numeral'
import swal from 'sweetalert'
import ProductZoomer from 'vue-product-zoomer'

Vue.use(ProductZoomer);

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

window.axios.interceptors.response.use((response) => {

    if(response.data.hasOwnProperty('message') && response.data.default === true){
        swal(response.data.message, {
            icon: 'success',
            timer: 2000
        })
    }

    return response
}, function (error) {
    if(error.response.status === 401){
        location.href = '/login'
    }

    return Promise.reject(error)
});


Vue.component('mini-cart', require('./components/mini-cart').default);
Vue.component('single-add-to-cart', require('./components/single-add-to-cart').default);
Vue.component('grid-product-option', require('./components/grid-product-option').default);
Vue.component('list-product-option', require('./components/list-product-option').default);
Vue.component('cart-page', require('./components/cart-page').default);
Vue.component('register', require('./components/register').default);
Vue.component('product-popup', require('./components/product-popup').default);
Vue.component('check-out-form', require('./components/proceed-to-checkout.vue').default);

Vue.component('profile-edit', require('./views/profile/edit').default);
Vue.component('cash-in', require('./views/wallet/cash-in').default);
Vue.component('image-gallery', require('./components/image-gallery').default);
Vue.component('upgrade-membership', require('./views/user/member').default);

Vue.filter('format', (value) => {
    return numeral(value).format('0,0.00')
});

const app = new Vue({
    el: "#page",
    store
});