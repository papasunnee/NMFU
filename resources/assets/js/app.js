
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./filters');

window.Vue = require('vue')
//import Vue from 'vue'
window.Form = Form


import { Form, HasError, AlertError } from 'vform'
import VueProgressBar from 'vue-progressbar'
import VueRouter from 'vue-router'
import routes from './routes'
import swal from 'sweetalert2'
window.swal = swal



Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(VueRouter)
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
  })


  const router = new VueRouter({
    mode: 'history',
    routes
})

const toast = swal.mixin({
    toast : true,
    position : 'top-end',
    showConfirmButton : 'false',
    timer: 3000
})

window.toast = toast


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});
