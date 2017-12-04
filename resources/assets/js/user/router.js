import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        //首页
        {
            path: '/',
            component: resolve =>void(require(['./User.vue'], resolve))
        },
        {
            name:'user/index',
            path: '/user/index',
            component: resolve =>void(require(['./components/Index.vue'], resolve))
        },
    ]
})
