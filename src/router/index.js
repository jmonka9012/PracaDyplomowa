import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TestView from '../views/test.vue'
import New from '@/views/New.vue'
import Blog from '@/views/Blog.vue'
import Single from '@/views/Single.vue'
import Contact from '@/views/Contact.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // {
    //   path: '/',
    //   name: 'home',
    //   component: HomeView,
    // },
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue'),
    // },
    // {
    //   path: '/test',
    //   name: 'test',
    //   component: test,
    // },
    {
      path: '/new',
      name: 'new',
      component: New,
    },
    {
      path: '/blog',
      name: 'blog',
      component:Blog,
      
    },
    {
      path: '/single',
      name: 'single',
      component:Single,
    },
    {
      path: '/kontakt',
      name: 'kontakt',
      component: Contact,
    },
  ],
})

export default router
