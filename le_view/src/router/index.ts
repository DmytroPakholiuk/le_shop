// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('@/layouts/default/Default.vue'),
    children: [
      {
        path: '',
        name: 'Home',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "home" */ '@/views/Home.vue'),
      },
      {
        path: 'category',
        name: 'Category',
        component: () => import(/* webpackChunkName: "home" */ '@/views/Category.vue'),
      },
      {
        path: 'login',
        name: 'Login',
        component: () => import(/* webpackChunkName: "home" */ '@/views/Login.vue'),
      },
      // {
      //   path: 'signup',
      //   name: 'Signup',
      //   component: () => import(/* webpackChunkName: "home" */ '@/views/Signup.vue'),
      // },
      {
        path: 'auth',
        name: 'Auth',
        component: () => import(/* webpackChunkName: "home" */ '@/views/Auth.vue'),
      }
    ],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
