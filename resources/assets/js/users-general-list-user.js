/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    // pjax
    $(document).pjax('ul.pagination li a', '.load-content-list-user');
});

$(document).ready(function () {
    if ($.support.pjax) {
        $.pjax.defaults.timeout = 60000; // time in milliseconds
        $.pjax.defaults.scrollTo = false;
    }

////    $('select[name="group[]"]').each(function() {
////        if ($(this).val() == '') {
////            $(this).next().find(".select2-selection__rendered").css("color", "#abafbb ");
////        } else {
////            $(this).next().find(".select2-selection__rendered").css("color", "#2b3c62 ");
////        }
////    });
//
////    $(document).ready(function () {
////        $(document).on('change', 'select[name="group[]"]', function () {
////            if ($(this).val() == '') {
////                $(this).next().find(".select2-selection__rendered").css("color", "#abafbb ");
////            } else {
////                $(this).next().find(".select2-selection__rendered").css("color", "#2b3c62 ");
////            }
////        });
////    });
    $('a.link-disabled').on('click', function(e){
       return false;
       e.preventDefault();
    });
    
   
   // Handle ajax for sort item
   $(document).on('change', '.list-common-user #sort_item', function(){
       var targetUrl = decodeURIComponent(window.location.href);
       var sortValue = $(this).val();
       if(targetUrl.indexOf('sort_item=') >= 0){
            targetUrl = targetUrl.replace(/sort_item=[0-9]:[0-9]/, 'sort_item='+sortValue);
        }else{
            targetUrl = targetUrl+'&sort_item='+sortValue;
        }
      
       
      $.pjax({
          url: targetUrl,
          container: '.load-content-list-user'
      });
   });
   
    $(document).on('pjax:end', function() {
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
                    wheelSpeed: 0.5,
                    minScrollbarLength: 90
                });
            },5);
        }).on("select2:close", function(e) { 
            if (ps) ps.destroy();
            ps = null;
        });
        
    });
   
    $('input[id^="hidden_month_"]').prop('disabled', true);
    $('input[id^="hidden_day_"]').prop('disabled', true);
    
    $(document).on('pjax:popstate', function(event) {
       $.pjax.reload('.load-content-list-user');
    });
    
    $('.template-3').on('click', function(){
       // Create Chart
        var ctx = document.createElement("canvas");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    onComplete: function(animation) {
                       imgf.setAttribute('src', this.toBase64Image());
                    }
                }
            }
        }); 
    });
});

/**
 * Handle error of ajax request
 * @param e
 * @returns view
 */
function handleError(e) {
    try {
        // If Login Error
        if(e.status === 401){
            if (e.responseJSON.type === 'login_other_browser'){
                location.reload();
                return;
            }
            else if(e.responseJSON.type === 'logout'){
                location.reload();
                return;
            }
        }
        if (typeof e.responseText != 'undefined' && e.responseText != '') {
            var error = JSON.parse(e.responseText);
            var params = '';
            if (!isBlank(error.message)) {
                params = error.code + "/" + decodeURIComponent(error.message);
            }
            window.location.href = window.location.href.split('users/general')[0] + 'error/' + params;
        }
    } catch (ex) {
        console.log(ex);
        window.location.href = window.location.href.split('users/general')[0] + 'error';
    }
}