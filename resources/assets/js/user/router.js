import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            path: '/super/password',
            component: resolve =>void(require(['./components/super/password.vue'], resolve))
        },
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
        // {
        //     name:'user/record/deposit',
        //     path: '/user/record/deposit',
        //     component: resolve =>void(require(['./components/user/record/Deposit.vue'], resolve))
        // },
        // {
        //     name:'user/record/takemoney',
        //     path: '/user/record/takemoney',
        //     component: resolve =>void(require(['./components/user/record/Takemoney.vue'], resolve))
        // },
        // {
        //     name:'user/record/transfer',
        //     path: '/user/record/transfer',
        //     component: resolve =>void(require(['./components/user/record/Transfer.vue'], resolve))
        // },
        
    ]
})
