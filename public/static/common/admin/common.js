/**
 * Created by Colorful on 2018/5/14.
 */
;
var common_ops = {
    init: function () {
        this.eventBind();
    },
    eventBind: function() {
        // TODO
    },
    buildUrl: function(path, params) {
        var domain = "http://" + window.location.hostname ;
        var url = domain + path;
        var _param_url = '';
        if( params ) {
            _param_url = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _param_url = "?"+_param_url;
        }
        return url + _param_url;
    }
};

$(document).ready( function() {
    common_ops.init();
});