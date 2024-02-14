import { createApp } from 'vue';
import axios from 'axios';

axios.defaults.withCredentials = true;
const userToken = localStorage.getItem('userToken');

// Make sure userToken is available
if (userToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${userToken}`;
}else {
    console.error('User token not found in local storage');
}
import { createRouter, createWebHistory } from 'vue-router';

import App from "./components/App.vue";
import RegisterComponent from './components/RegisterComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import FeedbackFormComponent from "./components/FeedbackFormComponent.vue";
import FeedbackListComponent from "./components/FeedbackListComponent.vue";
import UserComments from "./components/UserComments.vue";

const routes = [
    {
        path: '/',
        name: 'Dashboard',
        component: RegisterComponent,
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterComponent,
    },
    {
        path: '/login',
        name: 'login',
        component: LoginComponent,
    },
    {
        path: '/provide-feedback',
        name: 'provideFeedback',
        component: FeedbackFormComponent,
    },
    {
        path: '/feedback-list',
        name: 'feedbackList',
        component: FeedbackListComponent,
    },
    {
        path: '/user-comments/:itemId',
        name: 'UserComments',
        component: UserComments,
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
});

const app = createApp(App);

app.use(router);

app.mount('#app');
