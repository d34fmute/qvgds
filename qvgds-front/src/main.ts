import "./assets/style.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { createI18n } from "vue-i18n";

import App from "./App.vue";
import router from "./router";

import vSelect from 'vue-select'


const i18n = createI18n({
  // something vue-i18n options here ...
});

const app = createApp(App);

app.use(i18n);
app.use(createPinia());
app.use(router);

app.component('v-select', vSelect)

app.mount("#app");




