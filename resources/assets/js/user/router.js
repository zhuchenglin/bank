import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        //首页
        {
            path: '/',
            component: resolve =>void(require(['./components/Index.vue'], resolve))
        },
        // {
        //     name:'user/index',
        //     path: '/user/index',
        //     component: resolve =>void(require(['./components/Index.vue'], resolve))
        // },
        {
            name:'business/deposit',
            path: '/business/deposit',
            component: resolve =>void(require(['./components/business/Deposit.vue'], resolve))
        },
        {
            name:'business/takemoney',
            path: '/business/takemoney',
            component: resolve =>void(require(['./components/business/Takemoney.vue'], resolve))
        },
        {
            name:'business/transfer',
            path: '/business/transfer',
            component: resolve =>void(require(['./components/business/Transfer.vue'], resolve))
        },
        {
            name:'user/code',
            path: '/user/code',
            component: resolve =>void(require(['./components/user/Code.vue'], resolve))
        },
        {
            name:'user/info',
            path: '/user/info',
            component: resolve =>void(require(['./components/user/Info.vue'], resolve))
        },
    ]
})
