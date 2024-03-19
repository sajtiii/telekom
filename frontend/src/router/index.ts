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
      component: () => import('../views/Books/Create.vue')
    },
    {
      path: '/:id',
      name: 'books.show',
      component: () => import('../views/Books/Show.vue')
    },
    {
      path: '/:id/edit',
      name: 'books.edit',
      component: () => import('../views/Books/Edit.vue')
    }
  ]
})

export default router
