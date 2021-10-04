import Popper from 'popper.js'
import jQuery from 'jquery'
import axios from 'axios'
import swal from 'sweetalert'
import store from './store'

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = Popper
    window.$ = window.jQuery = jQuery;

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.axios.defaults.baseURL = location.origin+'/admin';

window.axios.interceptors.request.use(function (config) {
    store.commit('loadingStatus', true)


    return config;
}, function (error) {

    return Promise.reject(error);
});

window.axios.interceptors.response.use(function (response) {
    if(response.data.hasOwnProperty('message')){
        swal(response.data.message, {
            icon: "success",
            timer: 2000,
        })
    }
    store.commit('loadingStatus', false)
    return response;
}, function (error) {
    if(error.response.status != 422){
        swal(error.response.data.message, {
            icon: 'error'
        });
    }
    store.commit('loadingStatus', false)
    return Promise.reject(error);
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
