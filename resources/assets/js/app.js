import Vue from 'vue';
import VueRouter from 'vue-router';
import VueLazyload from 'vue-lazyload';
import axios from 'axios';
import vSelect from 'vue-select';
import VueTruncate from 'vue-truncate';

Vue.use(VueRouter);
Vue.use(VueLazyload);
Vue.use(VueTruncate);
Vue.component('v-select', vSelect);
window.Vue = Vue;
window.VueRouter = VueRouter;
window.axios = axios;