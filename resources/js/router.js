import Vue from 'vue';
import VueRouter from 'vue-router';
import AddListenings from './pages/AddListenings.vue';
import AllFilters from './pages/AllFilters.vue';

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
            component: AllFilters
        }
    ],
});

export default router;