$(document).ready(function () {

    /**
     * Show modal select guardian
     */
    $(document).on('click', '#select-guardian', function () {
        $('#search-modal').modal('show');
    });

    var listCourse = ' ';
    if ($('#guardian-type').val() == 2) {
        $('.student-block').removeClass('hide');
    } else {
        $('.student-block').addClass('hide');
    }

    $('select[name="group_id[]"]').each(function() {
        if ($(this).val() == '') {
            $(this).next().find(".select2-selection__rendered").css("color", "#abafbb");
        } else {
            $(this).next().find(".select2-selection__rendered").css("color", "#2b3c62");
        }
    });

    $(document).ready(function () {
        $(document).on('change', 'select[name="group_id[]"]', function () {
            if ($(this).val() == '') {
                $(this).next().find(".select2-selection__rendered").css("color", "#abafbb");
            } else {
                $(this).next().find(".select2-selection__rendered").css("color", "#2b3c62");
            }
        });
    });

    $('select[name="modal_group_id[]"]').each(function() {
        if ($(this).val() == '') {
            $(this).css("color", "#abafbb");
            $(this).children().css("color", "#2b3c62");
        } else {
            $(this).css("color", "#2b3c62");
        }
    });

    $(document).ready(function () {
        $(document).on('change', 'select[name="modal_group_id[]"]', function () {
            if ($(this).val() == '') {
                $(this).css("color", "#abafbb");
                $(this).children().css("color", "#2b3c62");
            } else {
                $(this).css("color", "#2b3c62");
            }
        });
    });

    /**
     * Fill checkbox in popup for all item selected and show modal
     */
    $(document).on('click', '#select-course', function () {
        $('input[name="course_id[]"]').each(function() {
            if(listCourse.indexOf(' ' + $(this).val() + ' ') === -1) {
                listCourse = listCourse + $(this).val() + " ";
            }
        });
        $('input[name="course_id_select"]').each(function() {
            if(listCourse.indexOf(' ' + $(this).val() + ' ') !== -1) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
        $('#course-modal').modal('show');
    });

    /**
     * Show or hide choose protector and course by guardian type
     */
    $(document).on('change', '#guardian-type', function () {
        if ($('#guardian-type').val() == 2) {
            $('.student-block').removeClass('hide');
        } else {
            $('.student-block').addClass('hide');
        }
    });

    /**
     * Choose course in popup
     */
    $(document).on('click', '#select-course-btn', function () {
        $('input[name="course_id_select"]').each(function() {
            if(listCourse.indexOf(' ' + $(this).val() + ' ') === -1 && $(this).is(":checked")) {
                listCourse = listCourse + $(this).val() + " ";
                var root = window.location.href.split('/users/general')[0];
                $('#list_course').append("<div id='course-" + $(this).val() + "'>"
                                 + "<image class='delete-course' data-course_id='" + $(this).val() + "' src='" + root + "/images/delete.png'/>" + $(this).data('name-course')
                                 + "<input type='hidden' name='course_id[]' value='" + $(this).val() + "'/>"
                                 + "<input type='hidden' name='course_name[]' value='" + $(this).data('name-course') + "'/></div>");
            } else {
                if(listCourse.indexOf(' ' + $(this).val() + ' ') >= 0 && !$(this).is(":checked")) {
                    listCourse = listCourse.replace($(this).val() + " ", "");
                    $('#course-' + $(this).val()).remove();
                }
            }
        });
    });

    /**
     * Delete course
     */
    $(document).on('click', '.delete-course', function () {
        $(this).parent().remove();
        if(listCourse.indexOf(' ' + $(this).data("course_id") + ' ') >= 0) {
            listCourse = listCourse.replace($(this).data("course_id") + " ", "");
            $('#course-' + $(this).data("course_id")).remove();
        }
    });

    /**
     * Search address by ajax
     */
    $(document).on('click', '#search-address', function () {
        var zipcode = $('#zipcode').val();
        if (isBlank(zipcode)) {
            $('#zipcode-block').parent().find('.error').remove();
            $('#zipcode-block').closest(".form-group").removeClass("has-error");
            if ($('#zipcode-block').data('zipcode_required') == true) {
                $('#zipcode-block').parent().append('<div class="error pull-left" id="zipcode-error">' + MSG.ZIPCODE_REQUIRED + '</div>');
                $('#zipcode-block').closest(".form-group").addClass("has-error");
            }
            return;
        }
        if (zipcode.length < 7) {
            $('#zipcode-block').parent().find('.error').remove();
            $('#zipcode-block').parent().append('<div class="error pull-left" id="zipcode-error">' + MSG.ZIPCODE_MAX_LENGH + '</div>');
            $('#zipcode-block').closest(".form-group").addClass("has-error");
            return;
        }
        $.ajax({
            url: '/users/general/individual/create/zipcode/' + zipcode,
            type: 'GET',
            success: function (data) {
                try {
                    var result = JSON.parse(data);
                    oldZipcode = zipcode;
                    $('#zipcode-block').parent().find('.error').remove();
                    if (!isBlank(result.prefecture_code)) {
                        $('select[name="name_4"]').val(result.prefecture_code).change();
                        $('input[name="name_5"]').val(result.city);
                        $('#zipcode-error').remove();
                        $('#zipcode-block').closest(".form-group").removeClass("has-error");
                    } else {
                        $('#zipcode-error').remove();
                        if (!isBlank(result.error) && $('#zipcode-error').length <= 0) {
                            $('#zipcode-block').parent().append('<div class="error pull-left" id="zipcode-error">' + result.error + '</div>');
                            $('#zipcode-block').closest(".form-group").addClass("has-error");
                        }
                        $('select[name="name_4"]').val('').change();
                        $('input[name="name_5"]').val('');
                    }
                } catch (ex) {
                    console.log(ex);
                    $('select[name="name_4"]').val('').change();
                    $('input[name="name_5"]').val('');
                    $('#zipcode-block').closest(".form-group").removeClass("has-error");
                    $('#zipcode-error').remove();
                }
            },
            error: function (e) {
                $('#zipcode-error').remove();
                handleError(e);
            }
        });
    });
});

/**
 * Check string is blank
 * @param str
 * @returns boolean
 */
function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}

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
        window.location.href = window.location.href.split('users/general')[0] + 'error';
    }
}