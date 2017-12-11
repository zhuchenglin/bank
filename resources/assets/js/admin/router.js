import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            path:'/',redirect:'/nav/user/index'
        },
        {
            name: 'nav',
            path: '/nav',
            component: resolve => void(require(['./components/Nav.vue'], resolve)),
            children: [
                {
                    name: 'user/index',
                    path: 'user/index',
                    component: resolve => void(require(['./user/UserIndex.vue'], resolve)),
                },
                {
                    name: 'account/index',
                    path: 'account/index',
                    component: resolve => void(require(['./account/AccountIndex.vue'], resolve)),
                },
                {
                    name: 'account/user/index',
                    path: 'account/user/index/:user_id',
                    component: resolve => void(require(['./account/AccountIndex.vue'], resolve)),
                }
            ]
        },

    ]
})
