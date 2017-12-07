import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Create from '@/components/Create'
import Get from '@/components/Get'

Vue.use(Router)

export default new Router({
  mode: 'history',
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
      meta: {title: 'Home'}
    },
    {
      path: '/create',
      name: 'Create',
      component: Create,
      meta: {title: 'Create'}
    },
    {
      path: '/get',
      name: 'Get',
      component: Get,
      meta: {title: 'Get'}
    }
  ]
})
