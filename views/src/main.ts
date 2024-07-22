import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import Router from "./router";
import Axios from "./plugins/axios.ts";
import { createPinia } from "pinia";
import persist from "pinia-plugin-persistedstate";
import createVuetify from "./plugins/vuetify.ts";
const app = createApp(App);

app.config.globalProperties.$axios = Axios;
const pinia = createPinia();
pinia.use(persist);
app.use(Router);
app.use(pinia);
app.use(createVuetify);
app.mount("#app");
