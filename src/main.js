import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import store from './store';
import router from './router';
import App from './App.vue';

if (!process.env.CONNECTION_STRING) {
  axios.defaults.baseURL = 'http://localhost:5000';
  axios.defaults.withCredentials = false;
}
Vue.use(VueAxios, axios);

new Vue({
  store,
  router,
  render: h => h(App),
}).$mount('#app');
