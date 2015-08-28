/**
 * Created by rmahr1 on 28.08.15.
 */
var gwstat = {
    conf: {

        dataTablesOptions: {
            lengthMenu: [[50, 100, 200, 500, -1], [50, 100, 200, 500, "Alle"]],
            searchHighlight: true
        },

        /**
         * default notify options
         */
        notifyOptions: {
            closeButton: true,
            showMethod: 'slideDown'
        }
    },

    init: function(baseUrl) {
        toastr.options = this.conf.notifyOptions;

        gwstat.baseUrl = baseUrl;

        //$.datepicker.setDefaults( $.datepicker.regional[ "de" ] );
    },

    debug: function(data) {
        if (typeof console !== 'undefined') {
            console.log(data);
        }
    }
};