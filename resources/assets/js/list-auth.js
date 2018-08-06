// Define global variable
var ROLE_STATUS_TRUE = 1;
var ROLE_STATUS_FALSE = 0;

var listAuth = new function () {

    this.models = {
        checkAll: ".checkAll",
        checkSingle: ".checkSingle",
        updateAuth: "#update-auth",
        okButton: "#btn-ok",
        responseBtn: "#response-btn",
    };

    this.init = function () {

        // Show confirm modal
        $(document).on('click', listAuth.models.updateAuth, function (e) {
            listAuth.events.showModal();
        });

        // Reload page when click response button
        $(document).on('click', listAuth.models.responseBtn, function (e) {
            location.reload();
        });

        // Set data value for each role
        $(document).on('click', listAuth.models.checkSingle, function (e) {
            if ($(this).attr('data-value') == ROLE_STATUS_TRUE) {
                $(this).attr("data-value", ROLE_STATUS_FALSE);
            } else {
                $(this).attr("data-value", ROLE_STATUS_TRUE);
            }
        });

        // Handle update user auth
        $(document).on('click', listAuth.models.okButton, function (e) {
            var data = {};

            $('.table-result tr').each(function () {

                var userId = $(this).attr('data-id');
                var authValue = [];

                if ($(this).find('input:checkbox').length > 0) {

                    $(this).find('input:checkbox').each(function (key, value) {
                        authValue.push($(value).attr('data-value'));
                    });

                    // Remove check all value from array
                    authValue.pop();
                    // Push auth value to update Data with key = user id
                    data[userId] = authValue;
                }
            });

            // Call Ajax to server and update
            listAuth.events.updateAuth(data);
        });

        // Check all check box function
        $(listAuth.models.checkAll).change(function () {
            var findTableRow = $(this).parent().parent().siblings();

            if ($(this).is(':checked')) {
                findTableRow.find(':not(.checkAll)').prop('checked', true);
                findTableRow.find(':not(.checkAll)').attr("data-value", ROLE_STATUS_TRUE);
            } else {
                findTableRow.find(':not(.checkAll)').prop('checked', false);
                findTableRow.find(':not(.checkAll)').attr("data-value", ROLE_STATUS_FALSE);
            }
        });

        // Check all is checked if all checkbox single is checked
        $(listAuth.models.checkSingle).click(function () {
            var findTableRow = $(this).parent().parent().siblings();

            if ($(this).is(":checked")) {
                var isAllChecked = false;

                findTableRow.find("input:checkbox:not('.checkAll')").each(function () {
                    if (!$(this).is(':checked')) {
                        isAllChecked = true;
                    }
                });

                if (!isAllChecked) {
                    findTableRow.find('.checkAll').prop('checked', true);
                }
            } else {
                findTableRow.find('.checkAll').prop('checked', false);
            }
        });
    };

    this.events = {

        // Show update modal pop up
        showModal: function showModal() {
            $('#confirm-update').modal('show');
        },

        // Show response message pop up
        showResponseModal: function showModal(messages) {
            $('#response-message').modal('show');
            $('.modal-row').text(messages);
        },

        updateAuth: function (updateData) {

            var url = location.protocol + "//" + location.host + '/auth/update';

            // Handle ajax send data to server
            $.ajax({
                type: 'POST',
                url: url,
                data: { updateData },
                success: function (res) {
                    // Show response message
                    if (res.message.success) {
                        listAuth.events.showResponseModal(res.message.success);
                    }
                    if (res.message.error) {
                        listAuth.events.showResponseModal(res.message.error);
                    }
                    if (res.message.notExist) {
                        listAuth.events.showResponseModal(res.message.notExist);
                    }
                },
                // Not do anything when error
                error: function (error) {
                    console.error(error);
                    return false;
                }
            });
        }
    };
}();

$(function () {
    listAuth.init();
});
