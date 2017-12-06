import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
        saveScrollPosition: true,
        routes: [
            //首页
            {
                path: '/',
                component: resolve =>void(require(['./components/Nav.vue'], resolve))
            },
        ]
})
