$(document).ready(function () {
    $(".us-year").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        todayHighlight: true,
        autoclose: true,
    });
    $(".us-month").datepicker({
        format: "m",
        viewMode: "months",
        minViewMode: "months",
        todayHighlight: true,
        autoclose: true,
    });
    $(".us-day").datepicker({
        format: "d",
        viewMode: "days",
        minViewMode: "days",
        todayHighlight: true,
        autoclose: true,
    });
    $(".us-datetime").datepicker({
        format: "yyyy/mm/dd",
        todayHighlight: true,
        autoclose: true,
    });

    $('.custom-datepicker').datepicker({ 
        dateFormat: "yy.mm.dd" 
    });

    if ($.fn.numeric) {
        $('input.number').numeric({
            maxDigits: $(this).attr('maxlength'),
            allowPlus           : false,

            // Allow the - sign
            allowMinus          : false, 

            // Allow the thousands separator, default is the comma eg 12,000
            allowThouSep        : false, 

            // Allow the decimal separator, default is the fullstop eg 3.141
            allowDecSep         : false, 
            allowLeadingSpaces  : false
        });
    }

    $(document).on('keydown', 'input.number', function (e) {
        if(e.keyCode == 229){

            // Check if preventDefault not working on browser
            // - isDefaultPrevented() return true if preventDefault worked, otherwise
            // - if not working, remove next characters
            var texts = $(this).val();
            if(!isBlank($(this).attr('maxlength')) && texts.length >= $(this).attr('maxlength')){
                $(this).val(texts.substring(0, $(this).attr('maxlength'))).trigger('change');
                return false;
            } else {
                return true;
            }
        }
        return isBlank($(this).attr('maxlength')) || $(this).val().length <= $(this).attr('maxlength');
    }).on('blur', function(e){
        var texts = $(this).val();

        if(!isBlank($(this).attr('maxlength')) && texts.length >= $(this).attr('maxlength')){
           $(this).val(texts.substring(0, $(this).attr('maxlength'))).trigger('change');
           return false;
        }else{
            return true;
        }
    });

    $('.birthday-block').each(function() {
        doChangeYmd('',$(this).attr('data-name'), $(this).attr('data-min'), $(this).attr('data-max'));
    });

});

/**
 * Function validate year, month, day when change combobox year, month, day
 * 
 * @param valName String
 * @param valSince String
 * @param valUntil String
 * 
 * @returns void
*/
function doChangeYmd (thisVal, valName, valSince, valUntil) {
    if (typeof valUntil == 'undefined') {
        return;
    }
    var intDay = calculDay(valName);
    var valMonth = $('#name_month'+valName).val();
    var valDay = $('#name_day'+valName).val();
    $year = $('#name_year'+valName).val();

    if(thisVal.value == "" || (valMonth == "" && valDay == "" && $year == "")) {
        if ($year == "" || valMonth == "") {
            
            if ((valMonth == "" && $year == "") || $year == "") {
                doAddDefaultMonthDay(valName, true, true);
            }
            if (valMonth == "") {
                doAddDefaultMonthDay(valName, true, false);
            }
            $('#name_day'+valName).val(valDay);
            $('#name_month'+valName).val(valMonth);
        }

        $('#hidden_name_'+valName).val("");
        return;
    }

    // Update Ymd since :
    if ($year != "" && $year == valSince.toString().substring(0, 4)) {
        if ($year == valUntil.toString().substring(0, 4)) {
            updateMonth(parseInt(valSince.toString().substring(4, 6)), parseInt(valUntil.toString().substring(4, 6)), valName);
            $month = $('#name_month'+valName).val();
            if($month == parseInt(valUntil.toString().substring(4, 6))) {
                if($month == parseInt(valSince.toString().substring(4, 6))) {
                    updateDay(parseInt(valSince.toString().substring(6, 8)), parseInt(valUntil.toString().substring(6, 8)), valName);
                } else {
                    updateDay(1, parseInt(valUntil.toString().substring(6, 8)), valName);
                }
            } else {
                updateDay(1, intDay, valName);
            }
        } else {
            updateMonth(parseInt(valSince.toString().substring(4, 6)), 12, valName);
            $month = $('#name_month'+valName).val();
            if($month == parseInt(valSince.toString().substring(4, 6))) {
                updateDay(parseInt(valSince.toString().substring(6, 8)), intDay, valName);
            } else{
                updateDay(1, intDay, valName);
            }
        }
    }

    // Update Ymd until :
    else if ($year != "" && $year == valUntil.toString().substring(0, 4)) {
        updateMonth(1, parseInt(valUntil.toString().substring(4, 6)), valName);
        $month = $('#name_month'+valName).val();
        if($month == parseInt(valUntil.toString().substring(4, 6))) {
            updateDay(1, parseInt(valUntil.toString().substring(6, 8)), valName);
        } else {
            updateDay(1, intDay, valName);
        }
    } else {
        updateMonth(1, 12, valName);
        updateDay(1, intDay, valName);
    }
    $("#name_month"+valName+" option[value='']").remove();
    $("#name_day"+valName+" option[value='']").remove();
    
    // sort select box month, day
    softSelect(valName, "name_day");
    softSelect(valName, "name_month");
    
    // update value selected for select box day
    $("#name_day"+valName).prepend("<option value=''></option>");
    if ($("#name_day"+valName+" option[value='"+valDay+"']").length > 0) {
        $('#name_day'+valName).val(valDay);
    } else {
        $('#name_day'+valName).val($('#name_day'+valName).find('option').first().val());
        doChangeYmd(valName, valSince, valUntil);
    }

    // update value selected for select box month
    $("#name_month"+valName).prepend("<option value=''></option>");
    if ($("#name_month"+valName+" option[value='"+valMonth+"']").length > 0) {
        $('#name_month'+valName).val(valMonth);
    }
    else {
        $('#name_month'+valName).val($('#name_month'+valName).find('option').first().val());
        doChangeYmd(valName, valSince, valUntil);
    }

    if($('#name_month'+valName).val() == "" || $('#name_day'+valName).val() == "" || $('#name_year'+valName).val() == "") {
        $('#hidden_name_'+valName).val("");
        return;
    }

    // Update value for hidden tag
    $('#hidden_name_'+valName).val($('#name_year'+valName).val() + '/' +$('#name_month'+valName).val()+ '/' + $('#name_day'+valName).val());
}

/**
 * Function sort select box
 * 
 * @param valName String
 * @param valDayMonth String
 * 
 * @returns void
*/
function softSelect (valName, valDayMonth) {
    var selectOptions = $("#" + valDayMonth + valName+" option");
    selectOptions.sort(function(a, b) {
        if (parseInt(a.text) > parseInt(b.text)) {
            return 1;
        }
        else if (parseInt(a.text) < parseInt(b.text)) {
            return -1;
        }
        else {
            return 0;
        }
    });
    $("#" + valDayMonth + valName).empty().append(selectOptions);
}

/**
 * Function update select box month
 * 
 * @param monthFrom int
 * @param monthTo int
 * @param valName String
 * 
 * @returns void
*/
function updateMonth (monthFrom, monthTo, valName) {
    for($count = 1; $count <= 12 ; $count++) {
        if (monthFrom <= $count && $count <= monthTo) {
            if (! $("#name_month"+valName+" option[value='"+$count+"']").length > 0) {
                $("#name_month"+valName).append("<option value='"+$count+"'>"+$count+"</option>");
            }
        }
        else {
            if ($("#name_month"+valName+" option[value='"+$count+"']").length > 0) {
                $("#name_month"+valName+" option[value='"+$count+"']").remove();
            }
        }
    }
    $("#hidden_month_"+valName).val(monthFrom+"-"+monthTo);
}

/**
 * Function update select box day
 * 
 * @param dayFrom int
 * @param dayTo int
 * @param valName String
 * 
 * @returns void
*/
function updateDay (dayFrom, dayTo, valName) {
    for($count = 1; $count <= 31 ; $count++) {
        if (dayFrom <= $count && $count <= dayTo) {
            if (! $("#name_day"+valName+" option[value='"+$count+"']").length > 0) {
                $("#name_day"+valName).append("<option value='"+$count+"'>"+$count+"</option>");
            }
        }
        else {
            if ($("#name_day"+valName+" option[value='"+$count+"']").length > 0) {
                $("#name_day"+valName+" option[value='"+$count+"']").remove();
            }
        }
    }
    $("#hidden_day_"+valName).val(dayFrom+"-"+dayTo);
}

/**
 * Function calcul day of month
 * 
 * @param valName String
 * 
 * @returns int : day in month
*/
function calculDay (valName) {
    $year = $('#name_year'+valName).val();
    $month = $('#name_month'+valName).val();
    $day = $('#name_day'+valName).val();
    switch ($month) {
        case "1" : case "3" : case "5" : case "7" : case "8" : case "10": case "12": case "":
            return 31;
        case "4" : case "6" : case "9" : case "11":
            return 30;
        case "2" :
            if ($year == "" || ((($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0))){
                return 29;
            }
            return 28;
    }
}

/**
 * Function update month, day default
 * 
 * @param valName String
 * @param isUpdateDay Boolean
 * @param isUpdateMonth Boolean
 * 
 * @returns update month, day default
*/
function doAddDefaultMonthDay (valName, isUpdateDay, isUpdateMonth) {
    if (isUpdateDay) {
        $("#name_day"+valName).find('option').remove();
        $("#name_day"+valName).prepend("<option value=''></option>");
        for($count = 1; $count <= 31 ; $count++) {
            $("#name_day"+valName).append("<option value='"+$count+"'>"+$count+"</option>");
        }
    }
    if (isUpdateMonth) {
        $("#name_month"+valName).find('option').remove();
        $("#name_month"+valName).prepend("<option value=''></option>");
        for($count = 1; $count <= 12 ; $count++) {
            $("#name_month"+valName).append("<option value='"+$count+"'>"+$count+"</option>");
        }
    }
}

function doChangeDateTime(thisVal, hiddenName) {
    if (!isBlank($(thisVal).val())) {
        $('input[name="' + hiddenName + '"]').val($(thisVal).val().replace(/(\.0)|(\.)/g,'/'));
    } else {
        $('input[name="' + hiddenName + '"]').val('');
    }
}

/**
 * Check string is blank
 * @param str
 * @returns boolean
 */
function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}