import webServices from 'WebServices';
import Nprogress from "nprogress";

export const axiosOptions = {headers: {'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest',},};



export default {
    namespaced: true,
    state:{
        user:         JSON.parse( localStorage.getItem('user') ),          //Usuario Autenticado
        access_token: localStorage.getItem('access_token'),                 //Token Passport del Usuario
        expires_at:   localStorage.getItem('expires_at'),                   //Fecha de Expiración del Token

        isUserSigninWithAuth0: Boolean(localStorage.getItem('isUserSigninWithAuth0'))
    },
    actions: {
        async signInWithLaravelPassport(context, payload) { //Iniciar Sesión mediante Laravel Passport
           Nprogress.start();

            return await new Promise((resolve, reject) => {
                webServices.post('/auth/login', payload, axiosOptions)
                    .then(response => {

                        let info = {
                            user:         response.data.user,
                            access_token: response.data.access_token,
                            expires_at:   response.data.expires_at,
                        }

                        context.commit('loginUserSuccess', info);

                        setTimeout(() => {
                            Nprogress.done();
                            resolve(response);
                        }, 500);
                    }).catch(error => {
                        Nprogress.done();
                        //context.commit('loginUserFailure', error.response.data);
                        Vue.notify({group: 'loggedIn', type: 'error', text: 'Usuario o Contraseña incorrectos'});
                        console.log('signInWithLaravelPassport ERROR', error.response);
                        reject(error)
                    });
            })
        },
    },
    mutations:
    {
        loginUserSuccess(state, user) { //Inicio de Sesión Exitoso
            state.user            = user.user;            localStorage.setItem('user', JSON.stringify(user.user));
            // state.roles           = user.roles;           localStorage.setItem('roles', JSON.stringify(user.roles));
            // state.permissions     = user.permissions;     localStorage.setItem('permissions', JSON.stringify(user.permissions));
            state.access_token    = user.access_token;    localStorage.setItem('access_token', user.access_token);
            state.expires_at      = user.expires_at;      localStorage.setItem('expires_at', user.expires_at);

            state.isUserSigninWithAuth0 = false

            Vue.notify({group: 'loggedIn', type: 'success', text: 'Bienvenido!'});
        },
    },
    getters:
    {
        user: state => {
            return state.user;
        },
    }
}
