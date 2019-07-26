import Vue from 'vue';

import DataTableComponent from './components/DataTableComponent';
/**
 * Create a fresh Vue Application instance
 */
new Vue({
    el: '#app',
    delimiters: ['${', '}'],
    components: {
        DataTableComponent,
    }
});