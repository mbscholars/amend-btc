import Vue from 'vue'
import VueRouter from 'vue-router'
import master from './layouts/master.vue'
import profile from './pages/profile.vue'
import example from './components/ExampleComponent.vue'

Vue.use(VueRouter)

export default new VueRouter({

    base: '/',
    routes:[
         {
            path : '/' ,
            component : master,
            children : [
                {
                    path: '/user/profile/settings',
                    component: profile,
                    name: "profile"
                },
     
                {
                    path: '/example',
                    component: example,
                    name: "example"
                },
     
            ],
         },
        ],
        mode: 'history',
})