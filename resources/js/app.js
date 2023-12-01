import './bootstrap';

import {createApp} from "vue/dist/vue.esm-bundler.js";
import {createRouter, createWebHistory} from "vue-router";
import routes from "./routes.js";
const app = createApp({});


const router = createRouter({
    routes: routes,
    history: createWebHistory(),
});

app.use(router);

app.mount('#app');

