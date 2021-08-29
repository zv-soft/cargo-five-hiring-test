import axios from 'axios';

let webService = axios.create({
    baseURL: window.location.origin+'/api/',    
});

export default webService;
