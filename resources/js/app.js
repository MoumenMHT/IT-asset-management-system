// resources/js/app.js

require('./bootstrap');

import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css'; // Add the DataTable CSS
import 'datatables.net'; // Import DataTable JS
import 'datatables.net-bs5'; 
import Vue from 'vue';  // Ensure Vue is imported

// Import Vuetify
import '@mdi/font/css/materialdesignicons.css'; // Import Material Design Icons
import 'vuetify/styles'; // Import Vuetify styles
import { createVuetify } from 'vuetify'; // Import Vuetify
import * as components from 'vuetify/components'; // Import Vuetify components
import * as directives from 'vuetify/directives'; // Import Vuetify directives

import { createApp } from 'vue';  // Use Vue 3's `createApp`
import RegisterForm from './components/RegisterForm.vue'; // Import RegisterForm
import LoginForm from './components/LoginForm.vue'; // Import LoginForm
import GetName from './components/GetName.vue'; // Import GetName
import App from './components/App.vue'; // Import App component
import router from './router.js';  // Import router

// Import jQuery for DataTables (if you still need it globally)
import $ from 'jquery'; // Ensure jQuery is available globally
window.$ = window.jQuery = $;

// Create Vue app for RegisterForm, LoginForm, and GetName components
const vuetify = createVuetify({
  components,  // Add Vuetify components to the vuetify instance
  directives,  // Add Vuetify directives
});

// Create Vue app for RegisterForm
const register = createApp(RegisterForm);
register.component('register-form', RegisterForm); // Register RegisterForm component globally
register.mount('#app'); // Mount Vue app to the #app div

// Create Vue app for LoginForm
const login = createApp(LoginForm);
login.component('login-form', LoginForm); // Register LoginForm component globally
login.mount('#login'); // Mount Vue app to the #login div

// Create Vue app for GetName form
const getName = createApp(GetName);
getName.component('user-name', GetName); // Register GetName component globally
getName.mount('#UserName'); // Mount Vue app to the #UserName div

// Create the main app instance
const app = createApp(App);

app.use(router); // Use the router

app.use(vuetify); // Use Vuetify

app.mount('#application');  // Mount the main Vue app to the #application div
