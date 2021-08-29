
require('./bootstrap');

import Vue from 'vue';
// router
import router from './router/index'

//Stores
import { store } from './store/store';

//Notificaciones
import Notifications from 'vue-notification'

import velocity from 'velocity-animate'

import App from './App.vue'

import Nprogress from 'nprogress'

import vuetify from './themes/vuetify';

window.Vue = require('vue').default;
Vue.use(Notifications, { velocity })

router.beforeEach((to, from, next) => {
    Nprogress.start()
    console.log(to.matched.some)
    to.matched.some(record => console.log(record))
	if (to.matched.some(record => record.meta.requiresAuth)) {
		// this route requires auth, check if logged in
		// if not, redirect to login page.

		if (localStorage.getItem('user') === null) {
			next({
				path: '/login',
				query: { redirect: to.fullPath }
			})
		} else {
			next()
		}
	} else {
		next() // make sure to always call next()!
	}
})

router.afterEach(() => {
	Nprogress.done()
	setTimeout(() => {
		const contentWrapper = document.querySelector(".v-content__wrap");
		if(contentWrapper !== null){
			contentWrapper.scrollTop = 0;
		}
		const boxedLayout = document.querySelector('.app-boxed-layout .app-content');
		if(boxedLayout !==  null){
			boxedLayout.scrollTop = 0;
		}
		const miniLayout = document.querySelector('.app-mini-layout .app-content');
		if(miniLayout !== null){
			miniLayout.scrollTop = 0;
		}
	}, 200);
})


const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    render: h => h(App),
	components: { App }
});
