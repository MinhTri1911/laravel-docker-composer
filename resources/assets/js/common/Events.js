/**
 * Event: Remove error message
 * Event auto remove error and message when input to error field 
 */
var Events = {
    /**
     * Init events method
     * @param array arrs
     * @returns void
     */
    init: function (arrs)
    {
        for(var index in arrs){
            Events[arrs[index]]();
        }
    },
    
    /**
     * Reset validate when change value on input bootstrap
     * @returns void
     */
    resetValidate: function ()
    {
        $(document).on('change paste keyup', '.form-control', function(){
            $(this).closest('.has-error').removeClass('has-error').find('help-block').text('');
            $(this).closest('.has-success').removeClass('has-success').find('help-block').text('');
        });
    },
    
    /**
     * Disabled submit
     * @returns void
     */
    disableSubmit: function ()
    {
        $(document).on('submit', 'form[data-disabled="true"]', function(){
            $(this).find('[type="submit"]').prop('disabled', true);
            
            var id = $(this).attr('id');
            
            if(id){
                $('[data-disabled-from="'+id+'"]').prop('disabled', true);
                $('[data-disabled-from="'+id+'"]').addClass('link-disabled', true);
            }
        });
    },
    
    /**
     * Disabled submit
     * @returns void
     */
    disableClick: function ()
    {
        $(document).on('click', '[data-click-disabled="true"]', function(){
            $(this).prop('disabled', true);
        });
    },

    /**
     * Disabled Link Click
     * @returns void
     */
    disableLinkClick: function ()
    {
        $(document).on('click', 'a[data-click-disabled="true"]', function(){
            $(this).addClass('link-disabled', true);
        });
    }
};


// Register event
//Events.init(["resetValidate"]);