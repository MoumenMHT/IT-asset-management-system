import { createRouter, createWebHistory } from 'vue-router';
import Contract from './components/contract/Form.vue';
import Magazin from './components/equipment/magazin.vue';
import Fournisseur from './components/fournisseur/fournisseur.vue';
import Structure from './components/structure/structure.vue';
import Employer from './components/employer/employer.vue';
import User from './components/user/user.vue';
import Affectation from './components/affectation/affectation.vue';


const routes = [
  { path: '/app', component: Contract },
  { path: '/magazin', component: Magazin },
  { path: '/fournisseur', component: Fournisseur },
  { path: '/structur', component: Structure },
  { path: '/employer', component: Employer },
  { path: '/user', component: User },
  { path: '/affectation', component: Affectation },

];



const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
