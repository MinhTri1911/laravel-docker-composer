$(document).ready(function () {
    $('.custom-datepicker').datepicker({
        dateFormat: "yy/mm/dd"
    });
    
    $('.icon-picker').on('click', function(e){
        $(this).parents('.group-datepicker').find('.custom-datepicker').focus();
    });
});
