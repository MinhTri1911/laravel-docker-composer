var App = {
    /**
     * Get info
     * @param string name name of attribute
     * @param string path this string will be concat at first when val is not empty
     * @returns string
     */
    getInfo: function(name, path)
    {
        var val = $('meta[name="support"]').attr(name);

        if(path != undefined && val != ""){
            val = path + val;
        }

        return val;
    },
    
    /**
     * Get url
     * 
     * @param string path
     * @returns string
     */
    getUrl: function(path)
    {
        var baseUrl = $('meta[name="support"]').attr('data-url');
        
        if (path != undefined) {
            if (path.charAt(0) == "/") {
                baseUrl = baseUrl + path;
            }
            // Concat string with "/"
            else {
                baseUrl = baseUrl + "/" + path;
            }
        }
        
        return baseUrl;
    },
    
    /**
     * Get token method
     */
    getToken: function()
    {
        return $('meta[name="csrf-token"]').attr('content');
    },
    
    /**
     * Get new csrf token
     * @param function success the method will be call when generate success
     * @returns mixed
     */
    getNewCsrfToken: function(success)
    {
        $.ajax({
            url: ROOT_URL + 'common/get-csrf-token',
            data: {},
            success: function(response){
                $('meta[name="csrf-token"]').attr('content', response);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': APP.getToken()
                    }
                });
                if(success != undefined){
                    success();
                }
            }
        });
    },
    
    /**
     * redirectErrorPage
     * @param {type} code
     * @param {type} message
     * @returns {undefined}
     */
    errorPage: function(code, message)
    {
        var form = document.createElement('form');
        $(form).attr({'method': 'POST', 'action': this.getUrl('/errors')});
        $(form).append('<input type="hidden" name="code" value="'+code+'"/>');
        $(form).append('<input type="hidden" name="message" value="'+message+'"/>');
        $(form).append('<input type="hidden" name="_token" value="'+this.getToken()+'"/>');
        $('body').append(form);
        $(form).submit();
    }
};

// add loading when call ajax
$( document ).ajaxStart(function() {	
    $( "#loading" ).show();
});
$(document).ajaxSuccess(function() {	
    $( "#loading" ).hide();
});
$( document ).ajaxError(function() {
    $( "#loading" ).hide();
});