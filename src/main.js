import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import store from './store';
import router from './router';
import App from './App.vue';

if (process.env.PROJECT_URL) {
  axios.defaults.baseURL = process.env.PROJECT_URL;
}

Vue.use(VueAxios, axios);

new Vue({
  store,
  router,
  render: h => h(App),
}).$mount('#app');
