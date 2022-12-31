import _ from 'lodash';
window._ = _;

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//import "admin-lte/plugins/jquery/jquery"; // <= erreur retournée : Uncaught ReferenceError: $ is not defined
// résolution :
window.$ = window.jQuery = require("jquery");
// fin résolution

// sweetAlert2
window.Swal = require("sweetalert2");

import "admin-lte/plugins/bootstrap/js/bootstrap.bundle";
import "admin-lte/dist/js/adminlte";