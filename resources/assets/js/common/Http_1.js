/**
 * Miêu tả
 *
 * @author RikkeiSoft
 * @date YYYY/MM/DD
 */
var Http = {
    /**
     * Check is exists URL method
     * @param string url
     * @param string callback
     * @returns void
     */
    isExistsUrl: function(url, callback)
    {
        $.ajax({
            type: 'HEAD',
            url: url,
            success: function(){
              callback(true);
            },
            error: function() {
              callback(false);
            }
        });
    }
};