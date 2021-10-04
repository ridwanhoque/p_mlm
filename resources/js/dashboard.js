import './bootstrap'
import _ from 'lodash'
import Vue from 'vue'
import numeral from 'numeral'
import router from './router'
import store from './store/index'
import helper from './helper/index'

import Dashboard from './views/layouts/dashboard'
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = Vue;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('dashboard', Dashboard)
Vue.component('app-loader', require('./components/app-loader').default)

Vue.mixin({
    methods: {
        isEmpty(obj){
            return _.isEmpty(obj)
        },
        willDelete(url, onSuccess){
            helper.methods.warning().then(() => {
                window.axios.delete(url).then((response) => {
                    onSuccess(response)
                })
            })
        }
    }
})

Vue.directive('selected', {
    bind(el){
        el.addEventListener('focus', () => {
            el.select()
        })
    }
})

Vue.directive('tooltip', {
    bind(el, binding){
        $(el).tooltip({
            title: binding.value
        })
    }
})

Number.prototype.percentOf  = function (percent) {
    return (this * percent / 100)
}

Number.prototype.formatted = function (decimal = 2) {
    return numeral(this).format(`0,0.${'0'.repeat(decimal)}`)
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
