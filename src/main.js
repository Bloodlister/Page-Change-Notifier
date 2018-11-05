import Vue from 'vue';
import Push from 'push.js';
import App from './App.vue';
import store from './store';

Vue.config.productionTip = false;
Vue.prototype.PushJS = Push;

new Vue({
  store,
  render: h => h(App),
}).$mount('#app');
