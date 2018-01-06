/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import axios from 'axios'
import VueAxios from 'vue-axios'
import BootstrapSocial from 'bootstrap-social';
import Home from './components/Home.vue';
import Contact from './components/Contact.vue';
import About from './components/About.vue';
import BookList from './components/BookList.vue';
import BookDetail from './components/BookDetail.vue';
import BookCategory from './components/BookCategory.vue';
import UserProfile from './components/UserProfile.vue';
import Passport from './components/passport/Passport.vue';
import MyBook from './components/MyBook.vue';
import 'font-awesome/css/font-awesome.css';
import VueProgressBar from 'vue-progressbar';
import 'vue-popperjs/dist/css/vue-popper.css';
import Popper from 'vue-popperjs';
import Echo from 'laravel-echo';
// import InfiniteLoading from 'vue-infinite-loading';

require('./bootstrap');
window.Vue = require('vue');
global.API = 'http://sanworld.io/api/v1.0/';
window.$ = window.jQuery = require('jquery');
const VueTruncate = require('vue-truncate-filter');


const options = {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px',
    thickness: '3px',
    transition: {
        speed: '1.5s',
        // opacity: '0.6',
        termination: 500
    },
    autoRevert: false,
    location: 'top',
    // inverse: false
}

Vue.use(VueProgressBar, options)
    /**
     * Next, we will create a fresh Vue application instance and attach it to
     * the page. Then, you may begin adding components to this application
     * or customize the JavaScript scaffolding to fit your unique needs.
     */


Vue.use(Vuex);
Vue.use(VueAxios, axios);
Vue.use(VueRouter);
Vue.use(BootstrapSocial);
Vue.use(VueTruncate);
Vue.use(Popper);
// Vue.user(Echo);


Vue.component('vue-footer', require('./components/Footer.vue'));
Vue.component('navbar', require('./components/Navbar.vue'));
Vue.component('feature', require('./components/Feature.vue'));
const meta = {
    progress: {
        func: [
            { call: 'color', modifier: 'temp', argument: 'green' },
            { call: 'fail', modifier: 'temp', argument: '#6e0000' },
            { call: 'location', modifier: 'temp', argument: 'top' },
            // { call: 'transition', modifier: 'temp', argument: { speed: '1.5s', opacity: '0.6s', termination: 400 } }
        ]
    }
};
const routes = [
    { path: '/', name: 'Home', component: Home, meta: meta },
    { path: '/books', name: 'BookList', component: BookCategory, meta: meta },
    { path: '/book/category/:category', name: 'BookCategory', component: BookCategory, meta: meta },
    { path: '/book/detail/:id', name: 'BookDetail', component: BookDetail, meta: meta },
    { path: '/contact', name: 'Contact', component: Contact, meta: meta },
    { path: '/about', name: 'About', component: About, meta: meta },
    { path: '/user/bookstore/:userID', name: 'MyBook', component: MyBook, meta: meta },
    { path: '/user/profile/:userID', name: 'UserProfile', component: UserProfile, meta: meta },
    // register router authentication passport
    { path: '/developer/passport', name: 'passport', component: Passport, meta: meta },
];

// init router
const router = new VueRouter({
    routes,
    hashbang: false,
    history: true,
    mode: 'history'
});


// init and export Vue
const app = new Vue({
    el: '#app',
    router
});

export default {
    mounted() {
        //  [App.vue specific] When App.vue is finish loading finish the progress bar
        this.$Progress.finish()
    },
    created() {
        //  [App.vue specific] When App.vue is first loaded start the progress bar
        this.$Progress.start()
            //  hook the progress bar to start before we move router-view
        this.$router.beforeEach((to, from, next) => {
                //  does the page we want to go to have a meta.progress object
                if (to.meta.progress !== undefined) {
                    let meta = to.meta.progress
                        // parse meta tags
                    this.$Progress.parseMeta(meta)
                }
                //  start the progress bar
                this.$Progress.start()
                    //  continue to next page
                next()
            })
            //  hook the progress bar to finish after we've finished moving router-view
        this.$router.afterEach((to, from) => {
            //  finish the progress bar
            this.$Progress.finish()
        })
    }
}