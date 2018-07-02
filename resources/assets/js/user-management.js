$(document).ready(function () {

    /**
     * Event on click input file csv
     * This will read information of file
     */
    $('.user-create-serial #cv_file').change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader(),
                fileName = this.files[0].name,
                $uploadInput = $('.user-create-serial .input-reference');

            reader.onload = function (e) {

                // Add file name to input
                $uploadInput.val(fileName);
            }
            reader.readAsDataURL(this.files[0]);
            $('#upload-csv').removeAttr('disabled');
        } else {
            $('#upload-csv').prop('disabled', true);
        }
    });

    /**
     * Event on click button
     * This will trigger click to input file
     */
    $('.user-create-serial .btn-reference').on('click', function () {
        $(this).parent().find('input[type="file"]').trigger('click');
    });

    /**
     * Event retrieve zipcode
     */
    var $zipcode = $('.zip-code');

    // Get element prefecture input
    var $prefecture = $('.prefecture');

    // Get element prefecture input
    var $city = $('.city');

    // handle ajax
    $zipcode.on('keyup change paste', function (e) {
        if (e.type =="paste" || (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 46 || e.keyCode == 45 || e.keyCode == 229) {
            // Value is this
            var $this = $(this);
            // Remove special characters from input
            if (e.type == "paste") {
                var $code = e.originalEvent.clipboardData.getData('text').replace(/[^0-9]+$/, '');
            }else{
                var $code = $this.val().replace(/[^0-9]+$/, '');
            }

            /**
             * Check if length of input is 7
             * Check handle ajax is true
             * Check if length of input not eval 7 (when backspace, delete...), change status handle ajax is 7
             */
            if ($code.length == 7) {
                try {
                    $.ajax({
                        url: '/admin/retrieve-zipcode',
                        data: {'find': $code, '_token': App.getToken()},
                        type: 'GET',
                        beforeSend: function (e) {
                            $prefecture.addClass('loading');
                            $city.addClass('loading');
                        },
                        success: function (data) {
                            $html = '';
                            $list = [];
                            // Check data from server is null
                            if (data.error) {
                                if (!$this.parent('div').hasClass('custom-error')) {
                                    $this.parent('div')
                                        .addClass('custom-error')
                                        .append('<div class="help-block">' + data.error + '</div>');
                                    $next = false;
                                    $prefecture.val("").trigger('change');
                                    $city.val("");
                                }
                                return null;
                            }
                            // Check data from server is true
                            $this.parent('div').removeClass('custom-error').find('.help-block').remove();

                            // Bind data to input and select dropdown
                            $prefecture.val(data[0].prefecture_code).trigger('change').removeClass('loading');
                            $city.val(data[0].city).removeClass('loading');

                            // Allow next handle continue
                            $next = true;
                            handle = false;
                        },
                        error: function (e) {
                            $next = false;
                            return $next;
                        },
                        timeout: 5000
                    });
                } catch (e) {
                    $prefecture.val("").trigger('change');
                    $city.val("");
                    return null;
                    console.log(e);
                }

            }else if($code.length > 7){
                if (!$this.parent('div').hasClass('custom-error')) {
                    $this.parent('div')
                        .addClass('custom-error')
                        .append('<div class="help-block">郵便番号が不正な値です。</div>');
                    $next = false;
                    $prefecture.val("").trigger('change');
                    $city.val("");
                }else{
                    $this.parent('div.custom-error').find('.help-block').html('郵便番号が不正な値です。');
                    $prefecture.val("").trigger('change');
                    $city.val("");
                }
            } else {
                // When user press backspace, delete character then change status handle
                // If length less than 3, back first list
                $prefecture.val('').trigger('change');
                $city.val('');
                if ($this.parent('div').hasClass('custom-error')) {
                    $this.parent('div')
                        .removeClass('custom-error')
                        .find('.help-block')
                        .remove();
                    $next = false;
                    e.preventDefault();
                }
            }
        }
        // Set current value in input
        currentValue = $(this).val();
        // When press input with max length allow
    }).on('blur', function(e){
        var $this = $(this);
        var $code = $this.val().replace(/[^0-9]+$/, '');
        if ($code.length == 7 && newValue !== currentValue) {
            try {
                $.ajax({
                    url: '/admin/retrieve-zipcode',
                    data: {'find': $code, '_token': App.getToken()},
                    type: 'GET',
                    beforeSend: function (e) {
                        $prefecture.addClass('loading');
                        $city.addClass('loading');
                    },
                    success: function (data) {
                        $html = '';
                        $list = [];
                        // Check data from server is null
                        if (data.error) {
                            if (!$this.parent('div').hasClass('custom-error')) {
                                $this.parent('div')
                                    .addClass('custom-error')
                                    .append('<div class="help-block">' + data.error + '</div>');
                                $next = false;
                                $prefecture.val("").trigger('change');
                                $city.val("");
                            }
                            return null;
                        }
                        // Check data from server is true
                        $this.parent('div').removeClass('custom-error').find('.help-block').remove();

                        // Bind data to input and select dropdown
                        $prefecture.val(data[0].prefecture_code).trigger('change').removeClass('loading');
                        $prefecture.val(data[0].city).removeClass('loading');

                        // Allow next handle continue
                        $next = true;
                    },
                    error: function (e) {
                        window.location.reload();
                        $next = false;
                        return $next;
                    },
                    timeout: 5000
                });
            } catch (e) {
                $prefecture.val("").trigger('change');
                $city.val("");
                return null;
            }
        }
    });

    $(".multiple-group").on('click', function () {
        var attr = $(this).parent().find('.table-select').attr('multiple');
        var $multipleSelect = $(this).parent().find('.table-select');
        var unSelect =$multipleSelect.find('option').first();
        
        if (typeof attr !== typeof undefined && attr !== false) {
            $multipleSelect.removeAttr("multiple");
            $multipleSelect.removeAttr('style');
            console.log(unSelect.val(), unSelect.val() != "");
            if(unSelect.val() != ""){
                if(!$multipleSelect.hasClass('_un_select')){
                    $multipleSelect.prepend('<option value="">未選択</option>');
                }
            }else{
                // Show back empty select (un select)
                $.each($multipleSelect.find('option'),function(){
                    let optionAttr = $(this).attr('value');
                    if (typeof optionAttr === 'undefined' || optionAttr === null || optionAttr === '') {
                        $(this).show();
                    } 
                });
            }
            
            
            $multipleSelect.select2({
                dropdownCssClass : "select2-table-select",
                minimumResultsForSearch: Infinity,
                width: '100%',
                allowClear: true
            }).trigger('change');
            $(this).next().val('');
        } else {
            $multipleSelect.select2('destroy');
            $multipleSelect.removeAttr("multiple");
            $multipleSelect.attr("multiple", true);
            
            // Hide empty sleect
            $.each($multipleSelect.find('option'),function(){
                let optionAttr = $(this).attr('value');
                if (typeof optionAttr === 'undefined' || optionAttr === null || optionAttr === '') {
                    $(this).hide();
                } 
            });
            $multipleSelect.css("background", 'none');
            $(this).next().val('1');
        }

    });

    $('#role-selected').change(function () {
        var role_id = $(this).val();
        $.ajax({
            url: '/admin/getRole',
            data: {'role_id': role_id, '_token': App.getToken()},
            type: 'POST',
            dataType: 'json',
            beforeSend: function (e) {
                $(this).addClass('loading');
            },
            success: function (data) {
                $('#operation-permission').html('');
                $html = '';
                $.each(data, function( index, value ) {
                    $html += '<tr>';
                    $html += '<td>' + value.function_name + '</td>';
                    $.each(value.arrOperations, function( index2, value2 ) {
                        if(value2) {
                            $html += '<td>' + value2 + '</td>';
                        } else {
                            $html += '<td></td>';
                        }
                    });
                    $html += '</tr>';
                });

                $('#operation-permission').html($html);
            },
            error: function (e) {
            },
            timeout: 5000
        });
    });

    $(document).on('submit', 'form[data-disabled="true"]', function(){
        $(this).append('<input type="hidden" name="search" value="1">');
        $(this).find('[type="submit"]').prop('disabled', true);

        var id = $(this).attr('id');

        if(id){
            $('[data-disabled-from="'+id+'"]').prop('disabled', true);
            $('[data-disabled-from="'+id+'"]').addClass('link-disabled', true);
        }
    });

    $('select[name="group_id[]"]').each(function() {
        if ($(this).val() == '') {
            $(this).css("color", "#abafbb ");
            $(this).find('option').css("color", "#2b3c62 ");
            $(this).find('option[value=""]').css("color", "#abafbb ");
        } else {
            $(this).css("color", "#2b3c62 ");
            $(this).find('option').css("color", "#2b3c62 ");
            $(this).find('option[value=""]').css("color", "#abafbb ");
        }
    });

    $(document).ready(function () {
        $(document).on('change', 'select[name="group_id[]"]', function () {
            if ($(this).val() == '') {
                $(this).css("color", "#abafbb ");
            } else {
                $(this).css("color", "#2b3c62 ");
            }
        });
    });

    // pjax
    $(document).pjax('ul.pagination li a', '.partial-load');

    if ($.support.pjax) {
        $.pjax.defaults.timeout = 10000; // time in milliseconds
        $.pjax.defaults.scrollTo = false;
    }
});

$(document).ready(function () {
    if ($.support.pjax) {
        $.pjax.defaults.timeout = 60000; // time in milliseconds
        $.pjax.defaults.scrollTo = false;
    }

    // Handle ajax for sort item
    $(document).on('change', '#sort-item', function(){
        var targetUrl = decodeURIComponent(window.location.href);
        var sortValue = $(this).val();
        targetUrl = targetUrl.replace(/sort_item=[a-z_]+/g, 'sort_item='+sortValue);

        $.pjax({
            url: targetUrl,
            container: '.partial-load'
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

    $(document).on('pjax:popstate', function(event) {
        $.pjax.reload('.load-content-list-user');
    });
    
    // Set align width
//    var widthAcc = [];
//    $('.group-account .form-group .left-side').each(function(){
//        widthAcc.push($(this).width());
//    });
//    
//    var maxWithAcc = Math.max(...widthAcc); // operate short way Math.max.apply(null, widthAcc);
//    $('.group-account .form-group .left-side').css({"width": maxWithAcc});
//    $('.group-account .form-group .right-side').css({"width": "calc(100% - "+maxWithAcc+"px)"});
//    
//    var widthPrf = [];
//    $('.group-profile .form-group .left-side').each(function(){
//        widthPrf.push($(this).width());
//    });
//    
//    var maxWidthPrf = Math.max(...widthPrf); // operate short way Math.max.apply(null, widthAcc);
//    $('.group-profile .form-group .left-side').css({"width": maxWidthPrf+20});
//    $('.group-profile .form-group .right-side').css({"width": "calc(100% - "+(maxWidthPrf+20)+"px)"});
 
//    console.log($('.form-group .left-side').width());
});
