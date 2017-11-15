
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');
require('../common.js');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import User from "./User.vue"
import router from './router'
import {filters} from './filter'
import ElementUI from "element-ui"
import 'element-ui/lib/theme-default/index.css';


require("es6-promise").polyfill()

Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key])
})

const FastClick = require('fastclick')
FastClick.attach(document.body)

// //添加响应拦截器
window.axios.interceptors.response.use(
    response => {
    return response;
},
error => {
    //请求错误时做些事
    if (error.response) {
        switch (error.response.status) {
            case 401:
                // window.location.href = "/login";
                break;
        }
    }
    return Promise.reject(error.response.data);

});

Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    router,
    render:h=>h(User)
});
