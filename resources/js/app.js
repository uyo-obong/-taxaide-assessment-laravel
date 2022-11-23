import './bootstrap';

import { createApp } from 'vue'
import store from "./store"
import router from "./routes";
import MainComponent from "./components/MainComponent";


const app = createApp(MainComponent)
app.use(router)
app.use(store)
app.mount('#app')

