import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'books.index',
      component: () => import('../views/Books/Index.vue')
    },
    {
      path: '/create',
      name: 'books.create',
      component: () => import('../views/Books/Form.vue'),
      props: { isCreate: true, isShow: false, id: null }
    },
    {
      path: '/:id',
      name: 'books.show',
      component: () => import('../views/Books/Form.vue'),
      props: { isCreate: false, isShow: true, id: (route) => route.params.id }
    },
    {
      path: '/:id/edit',
      name: 'books.edit',
      component: () => import('../views/Books/Form.vue'),
      props: { isCreate: false, isShow: false, id: (route) => route.params.id }
    }
  ]
})

export default router
