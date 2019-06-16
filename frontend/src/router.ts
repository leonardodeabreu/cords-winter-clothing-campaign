import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import Score from './views/Score.vue';

Vue.use(Router);

export default new Router({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
    },
    {
      path: '/score',
      name: 'score',
      component: Score,
    },
    {
      path: '/cords',
      name: 'cords',
      component: () => import('./views/Cords.vue'),
    },
    {
      path: '/team/:team',
      name: 'team',
      component: () => import('./views/Team.vue'),
    },
    {
      path: '/admin',
      component: () => import('./views/admin/Admin.vue'),
      children: [
        {
          path: '/',
          name: 'donation-list',
          component: () => import('./views/admin/DonationScore.vue'),
        },
        {
          path: 'form/:id?',
          name: 'donation-form',
          meta: { type: 'donation' },
          component: () => import('./views/admin/Form.vue'),
        },
      ],
    },
    {
      path: '/admin',
      component: () => import('./views/admin/Admin.vue'),
      children: [
        {
          path: 'player',
          name: 'player-list',
          meta: { type: 'player' },
          component: () => import('./views/admin/DataTable.vue'),
        },
        {
          path: 'player/:id?',
          name: 'player-form',
          meta: { type: 'player' },
          component: () => import('./views/admin/Form.vue'),
        },
      ],
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('./views/admin/Login.vue'),
    },
  ],
});
