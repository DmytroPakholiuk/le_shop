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
      },
      {
        path: 'goods/create',
        name: 'GoodsCreate',
        component: () => import(/* webpackChunkName: "home" */ '@/views/GoodsCreateForm.vue'),
      },
      {
        path: "goods/:id/update",
        name: "goodsUpdate",
        component: () => import(/* webpackChunkName: "home" */ '@/views/GoodsUpdateForm.vue')
      },
      {
        path: "unauthorized",
        name: "unauthorized",
        component: () => import(/* webpackChunkName: "home" */ '@/views/Unauthorized.vue')
      },
      {
        path: "goods",
        name: "goodsList",
        component: () => import(/* webpackChunkName: "home" */ '@/views/GoodsList.vue')
      },
      {
        path: "goods/:id",
        name: "goodsView",
        component: () => import(/* webpackChunkName: "home" */ '@/views/GoodsView.vue')
      }
    ],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
