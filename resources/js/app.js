/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Router from 'vue-router'
import VueFlashMessage from 'vue-flash-message';

import App from './views/App'
import Messages from './views/Messages'
import MessagesSent from './views/MessagesSent'
import MessagesArchived from './views/MessagesArchived'
import Compose from './views/Compose'
import Bin from './views/Bin'

Vue.use(Router);
Vue.use(VueFlashMessage);


const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/app',
            name: 'messages',
            component: Messages,
        },
        {
            path: '/app/messages/sent',
            name: 'messages/sent',
            component: MessagesSent,
        },
        {
            path: '/app/messages/archived',
            name: 'messages/archived',
            component: MessagesArchived,
        },
        {
            path: '/app/compose',
            name: 'compose',
            component: Compose,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
