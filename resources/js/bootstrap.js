import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// resources/js/bootstrap.js

window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// → Ajoute cette ligne pour charger le bundle JS de Bootstrap
import 'bootstrap';
