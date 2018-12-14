require('./bootstrap');

import Vue from 'vue';

import Datetime from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(Datetime)

Vue.component('group-select', require('./components/GroupSelect.vue'));
Vue.component('policy-table', require('./components/PolicyTable.vue'));

$(document).ready( function(){
    const app = new Vue({
        el: '#app',
        data :{
            loading : false,
            loadingStaff: false,
            datetime: null
        }
    });

    $('input[type=file]').change(function () {
        $(this).next('.custom-file-label').html('File uploaded');
    })
});
