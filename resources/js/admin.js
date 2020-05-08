window.$ = require('jquery');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

require('./bootstrap.bundle');

require('./sb-admin.js');

require('./datatables/dataTables.bootstrap4');

require('jquery-ui');

require('./nestedSortable');

require('select2/dist/js/select2.min');

require('summernote/dist/summernote-bs4')
