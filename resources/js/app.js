require('./bootstrap');

import Vue from 'vue';

Vue.component('group-select', require('./components/GroupSelect.vue'));
Vue.component('policy-table', require('./components/PolicyTable.vue'));

$(document).ready( function(){
    const app = new Vue({
        el: '#app',
        data :{
            loading : false,
            loadingStaff: false
        }
    });

    $('input[type=file]').change(function () {
        $(this).next('.custom-file-label').html('File uploaded');
    })
});
