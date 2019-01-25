require('./bootstrap');

import Vue from 'vue';
import InstantSearch from 'vue-instantsearch';
import Datetime from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'; // You need a specific loader for CSS files

Vue.use(Datetime)
Vue.component('group-select', require('./components/GroupSelect.vue'));
Vue.component('document-table', require('./components/DocumentTable.vue'));
Vue.component('student-select', require('./components/StudentSelect.vue'));
Vue.component('tag-select', require('./components/TagSelect.vue'));

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
