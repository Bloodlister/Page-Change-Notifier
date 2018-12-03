import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import store from './store';
import router from './router';
import App from './App.vue';

Vue.use(VueAxios, axios);
Vue.axios.defaults.baseURL = 'https://notifier-for-new-cars.herokuapp.com';

new Vue({
  store,
  router,
  render: h => h(App),
}).$mount('#app');
