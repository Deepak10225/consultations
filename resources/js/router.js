import { createRouter, createWebHistory } from 'vue-router';
import Home from './Components/dashboard.vue';
import Login from './Components/auth/login.vue';
import ConsultationList from './Components/Consultations/ConsultationList.vue';
import ConsultationForm from './Components/Consultations/ConsultationForm.vue';
import ConsultationEdit from './Components/Consultations/ConsultationEdit.vue';
import ConsultationView from './Components/Consultations/ConsultationView.vue';
const routes = [
  { path: '/home', name: 'home', component: Home, meta: { requiresAuth: true } },
  { path: '/', name: 'Login', component: Login },
   { path: '/consultations', name: 'ConsultationList', component: ConsultationList, meta: { requiresAuth: true } },
  { path: '/consultations/new', name: 'ConsultationCreate', component: ConsultationForm, meta: { requiresAuth: true } },
  { path: '/consultations/:id/edit', name: 'ConsultationEdit', component: ConsultationEdit, meta: { requiresAuth: true } },
 { path: '/consultations/:id',name: 'consultation-view',component: ConsultationView,props: true }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  if (to.meta.requiresAuth && !token) {
    next('/');
  } else {
    next();
  }
});

export default router;
