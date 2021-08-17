require('./bootstrap');

window.Vue = require('vue');
window.Fire = new Vue();
// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Install BootstrapVue
// Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
// Vue.use(IconsPlugin)


import VueToastr from "vue-toastr";
Vue.use(VueToastr, {
    defaultTimeout: 3000,
    defaultPosition: "toast-top-right",
    defaultProgressBar: false,
    defaultProgressBarValue: 0,
});



import Swal from 'sweetalert2'
window.swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.toast = Toast;
import { Form, HasError, AlertError } from 'vform'


window.Form = Form;


// import JwPagination from 'jw-vue-pagination';
// Vue.component('jw-pagination', JwPagination);

// Require Froala Editor js file.
require('froala-editor/js/froala_editor.pkgd.min.js')

// Require Froala Editor css files.
require('froala-editor/css/froala_editor.pkgd.min.css')
require('froala-editor/css/froala_style.min.css')

// Import and use Vue Froala lib.

// import VueFroala from 'vue-froala-wysiwyg'
// Vue.use(VueFroala)

import ViewDesign from 'view-design'
import 'view-design/dist/styles/iview.css';
Vue.use(ViewDesign)


Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

require('./component');

Vue.filter('str_limit', function (value, size) {
    if (!value) return '';
    value = value.toString();
    if (value.length <= size) {
        return value;
    }
    return value.substr(0, size) + '...';
});


import SmartTable from 'vuejs-smart-table'
Vue.use(SmartTable)

import CKEditor from 'ckeditor4-vue';

Vue.use(CKEditor);

window.baseUrl = window.location.origin

const app = new Vue({
    el: '#app'
});



