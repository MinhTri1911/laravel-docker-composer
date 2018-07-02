/**
 * RUN FOR ALL PAGE
 */
$(document).ready(function () {

    // Auto set token to header of ajax post
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': App.getToken()
        }
    });
    
    // Layout register event
    Events.init(['disableSubmit', 'disableClick', 'disableLinkClick']);

    /**
     * On click go top arrow
     */
    $('a[href*="#"]:not([href="#"]):not([role="tab"])').click(function() {
      var target;
      if (document.location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && document.location.hostname === this.hostname) {
        target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 1000);
          return false;
        }
      }
    });

    // Check display scroll button
    function displayScrollButton ()
    {
        var scroll = $(window).scrollTop();
        if (scroll > 10){
            $('a#go-top').fadeIn(200);
        }
    }
    
    /**
     * Check Scroll Gotop
     */
    $(window).scroll(function (event) {
        $('a#go-top').fadeOut(200);
    });
    
    // extension:
    $.fn.scrollEnd = function(callback, timeout) {          
        $(this).scroll(function(){
            var $this = $(this);
            if ($this.data('scrollTimeout')) {
                clearTimeout($this.data('scrollTimeout'));
            }
              
            $this.data('scrollTimeout', setTimeout(callback,timeout));
        });
    };

    // how to call it (with a 1000ms timeout):
    $(window).scrollEnd(displayScrollButton, 600);

    displayScrollButton();
    
    // Custom Select2
    $( ".custom-select select" ).select2({
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
            ps = new PerfectScrollbar('.select2-container .select2-results > .select2-results__options',{
                // wheelSpeed: 0.1,
                minScrollbarLength: 90
            });
        },5);
    }).on("select2:close", function(e) { 
        if (ps) ps.destroy();
        ps = null;
    });

    // Table Dropdown Select
    $( "table.table-dropdown td .item select.table-select:not([multiple])" ).select2({
        dropdownCssClass : "select2-table-select",
        minimumResultsForSearch: Infinity,
        width: '100%',
        placeholder: $(this).data('placeholder'),
        allowClear: true
    });

    $(document).on('click','.table-btn-add',function(){
        var $parentSelectTable = $(this).parent().find('.custom-select-table'),
            $btnSelectTable = $(this).parent().find('.custom-select-table .table-select');
        if($btnSelectTable.attr("multiple") !== 'multiple'){
            $btnSelectTable.select2('destroy');
            $btnSelectTable.attr("multiple",  "multiple");

            var optionHeight = 0;
            $parentSelectTable.addClass('multiple-select');
            $.each($btnSelectTable.find('option'),function(){
                let optionAttr = $(this).attr('value');
                if (typeof optionAttr === 'undefined' || optionAttr === null || optionAttr === '') {
                    $(this).remove();
                } else {
                    optionHeight+= ($(this).outerHeight() === 36 ) ? $(this).outerHeight() : 16;
                }
            });

            $btnSelectTable.height(optionHeight);
            psmulti = new PerfectScrollbar($parentSelectTable[0],{
                wheelSpeed: 0.5,
                minScrollbarLength: 90
            });
        }
    });
    
    //Handle redirect link API
    $('a.ss-link').on('click', function(e){
       var pathRedirect = $(this).data('path-redirect');
       e.preventDefault();
       $.ajax({
          type: 'GET',
          data: {'path-redirect': pathRedirect},
          url: '/page/api/call-redirect-url',
          success: function(data){
//             window.location.href = data;
             window.open(data, '_blank');
          },
          error: function(e){
              window.location.reload();
          }
       });
    });
});