import './bootstrap';
import { createApp } from 'vue';

// Import your Vue components
import HomeComponent from './components/HomeComponent.vue';

const app = createApp({});

// Register components
app.component('home-component', HomeComponent);

app.mount('#app');