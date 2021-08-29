import webServices from 'WebServices';
import Nprogress from "nprogress";
export const axiosOptions = {
    headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem(
            "access_token"
        )}`
    }
};

export default {
    namespaced: true,
    state:{
      listContracts:[],
      contract:null,
    },
    actions: {
        async store(context, data) {
           Nprogress.start();
            return await new Promise((resolve, reject) => {
                webServices.post('/contract/store', data, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "multipart/form-data",
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`
                    }
                })
                    .then(response => {

                        resolve(response.data)
                        Nprogress.done();
                    }).catch(error => {
                        Nprogress.done();

                        console.log('Load Contract ERROR', error.response);
                        reject(error)
                    });
            })
        },

        async getAll(context) {
            Nprogress.start();
             return await new Promise((resolve, reject) => {
                 webServices.get('/contract/index', {
                     headers: {
                         "Content-Type": "multipart/form-data",
                         "X-Requested-With": "XMLHttpRequest",
                         Accept: "multipart/form-data",
                         Authorization: `Bearer ${localStorage.getItem(
                             "access_token"
                         )}`
                     }
                 })
                .then(response => {
                context.commit('setContracts', response.data)
                Nprogress.done();
                }).catch(error => {
                Nprogress.done();
                console.log('Load Contract ERROR', error.response);
                });
             })
         },

        async getContractByID(context, data) {
            Nprogress.start();
             return await new Promise((resolve, reject) => {
                 webServices.get('/contract/getContractbyID/'+data, {
                     headers: {
                         "Content-Type": "multipart/form-data",
                         "X-Requested-With": "XMLHttpRequest",
                         Accept: "multipart/form-data",
                         Authorization: `Bearer ${localStorage.getItem(
                             "access_token"
                         )}`
                     }
                 })
                .then(response => {

                context.commit('setContract', response.data)
                Nprogress.done();
                }).catch(error => {
                Nprogress.done();
                console.log('Load Contract ERROR', error.response);
                });
             })
         },
    },
    mutations:
    {
        setContracts(state,value)
        {
            state.listContracts = value
        },

        setContract(state, value)
        {
            state.contract = value;
        }
    },
    getters:
    {
        listContracts: state => {
            return state.listContracts;
        },

        contract:state=>{
            return state.contract;
        }
    }
}

