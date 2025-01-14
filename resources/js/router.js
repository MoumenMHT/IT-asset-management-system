import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

// Import Vue components
import Contract from './components/contract/Form.vue';
import Magazin from './components/equipment/magazin.vue';
import Fournisseur from './components/fournisseur/fournisseur.vue';
import Structure from './components/structure/structure.vue';
import Employer from './components/employer/employer.vue';
import User from './components/user/user.vue';
import Affectation from './components/affectation/affectation.vue';
import Dashboard from './components/dashboard/dashboard.vue';
import Login from './components/LoginForm.vue';
import Signup from './components/RegisterForm.vue';

// Define routes
const routes = [
  { path: '/login', component: Login },
  { path: '/signup', component: Signup },
  { path: '/app', component: Contract, meta: { requiresAuth: true } },
  { path: '/magazin', component: Magazin, meta: { requiresAuth: true } },
  { path: '/fournisseur', component: Fournisseur, meta: { requiresAuth: true } },
  { path: '/structure', component: Structure, meta: { requiresAuth: true } },
  { path: '/employer', component: Employer, meta: { requiresAuth: true } },
  { path: '/user', component: User, meta: { requiresAuth: true } },
  { path: '/affectation', component: Affectation, meta: { requiresAuth: true } },
  { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  axios.get('/api/check-auth', {
    headers: {
      'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
    },
    withCredentials: true
  })
  .then(({ data }) => {

    if (to.meta.requiresAuth && !data.authenticated) {

      window.location.href = `/`;
    } else {
      next();
    }
  })
  .catch(() => {
    if (to.meta.requiresAuth) {
      window.location.href = `/`;
    } else {
      next();
    }
  });
});


export default router;
