require('./bootstrap');
import router from "./router";
import axios  from 'axios';
import VueAxios from 'vue-axios';

window.Vue = require('vue');

Vue.use(VueAxios, axios);
import App from './components/App.vue';

new Vue({
    router,
    render: h => h(App)
}).$mount('#app');