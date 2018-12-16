import Vue from 'vue';
import VueRouter from 'vue-router';
import AddListenings from './pages/AddListenings.vue';
import AllListenings from './pages/AllListenings.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: "home",
            component: AddListenings
        },
        {
            path: '/all',
            name: 'all',
            component: AllListenings
        }
    ],
});

export default router;