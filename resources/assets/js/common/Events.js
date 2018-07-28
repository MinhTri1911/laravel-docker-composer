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
        for (var index in arrs) {
            Events[arrs[index]]();
        }
    },

    /**
     * Reset validate when change value on input bootstrap
     * @returns void
     */
    resetValidate: function ()
    {
        $(document).on('change paste keyup', '.form-control', function () {
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
        $(document).on('submit', 'form[data-disabled="true"]', function () {
            $(this).find('[type="submit"]').prop('disabled', true);

            var id = $(this).attr('id');

            if (id) {
                $('[data-disabled-from="' + id + '"]').prop('disabled', true);
                $('[data-disabled-from="' + id + '"]').addClass('link-disabled', true);
            }
        });
    },

    /**
     * Disabled submit
     * @returns void
     */
    disableClick: function ()
    {
        $(document).on('click', '[data-click-disabled="true"]', function () {
            $(this).prop('disabled', true);
        });
    },

    /**
     * Disabled Link Click
     * @returns void
     */
    disableLinkClick: function ()
    {
        $(document).on('click', 'a[data-click-disabled="true"]', function () {
            $(this).addClass('link-disabled', true);
        });
    },

    /**
     * Format number
     * @returns void
     */
    separateComma: function (domObj) {
        domObj.val(function (index, value) {
            return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
        });
    },

    separateCommaValue: function (value) {
        return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
    },

    /**
     * Initialize select2 after render
     * @returns void
     */
    initSelect2: function () {
        $(".custom-select select" ).select2({
            theme: "bootstrap",
            width: '100%',
            minimumResultsForSearch: Infinity,
            allowClear: true
        });

        var ps;

        $(".custom-select select, .custom-select-table:not(.multiple-select) .table-select").on("select2:open", function(e) {
            if (ps) ps.destroy();

            var ps;
            setTimeout(function(){
                ps = new PerfectScrollbar('.select2-container .select2-results > .select2-results__options', {
                    minScrollbarLength: 90
                })
            }, 5);
        }).on("select2:close", function(e) {
            if (ps) ps.destroy();

            ps = null;
        });
    }
};


// Register event
//Events.init(["resetValidate"]);