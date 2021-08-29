import Vue from 'vue'
import Router from 'vue-router'

const Home = () => import('../view/Home.vue');
const Login = () => import('../view/Login.vue');
/**
 *
 * Dashboard
 */
const Dashboard = () => import('../view/Dashboard/index.vue');

/**
 *
 * @returns Vista relacionadas a los contratos
 */
const LoadContract = () => import('../view/Dashboard/Contracts/loadContract.vue')
const ViewContract = () => import('../view/Dashboard/Contracts/viewContract.vue')
const ViewAllContracts = () => import('../view/Dashboard/Contracts/viewAllContract.vue')






Vue.use(Router)

export default new Router({
    mode: 'history',
    routes:[
        {
            path:'/',
            name:'Home',
            component:Home,
        },
        {
            path:'/login',
            name:'Login',
            component:Login,
        },
        //Rutas del dahboard
        {
            path:'/Dashboard',
            name:'Dashboard',
            meta: {
                requiresAuth: true,
            },
            component:Dashboard,
        },

        //Rutas de contratos

        {
            path:'/LoadContract',
            name:'LoadContract',
            meta: {
                requiresAuth: true,
            },
            component:LoadContract,
        },
        {
            path:'/ViewContract/:id?',
            name:'ViewContract',
            meta: {
                requiresAuth: true,
            },
            component:ViewContract,
        },

        {
            path:'/ViewContracts',
            name:'ViewContracts',
            meta: {
                requiresAuth: true,
            },
            component:ViewAllContracts,
        }
    ]
})
