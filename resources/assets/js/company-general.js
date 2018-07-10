/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var company = new function () {
    this.model = {
        selectModal: '#modal-protector'
    }

    /**
     * Function click button setting billing show popup
     * @returns void
     */
    this.showSettingBillingMethod = function () {
        let companyObject = this;
        // Binding parameter to event click
        $('#btn-setting-billing').bind('click', {companyObject: companyObject}, function (event) {
            let url = $(this).attr('data-url');
            // Set param for check currency id in server
            let param = {
                'current-url' : window.location.href
            }

            $.get(url, param,function (res) {
                if (res.code !== 200) {
                    alert('Error');
                    return;
                }

                event.data.companyObject.appendData(res.view);
                event.data.companyObject.initSelect2();
            })
        })
    };

    /**
     * Function append data to modal-protector
     * @returns void
     */
    this.appendData = function (view) {
        $(this.model.selectModal).empty();
        $(this.model.selectModal).append(view);
        $(this.model.selectModal).modal('show');
    };

    /**
     * Initialize select2 after render
     * @returns void
     */
    this.initSelect2 = function () {
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
                    // wheelSpeed: 0.1,
                    minScrollbarLength: 90
                })
            }, 5);
        }).on("select2:close", function(e) {
            if (ps) ps.destroy();

            ps = null;
        });
    };

    /**
     * Initialize datepicker after render
     * @returns void
     */
    this.initDatePicker = function () {
        $('.custom-datepicker').datepicker({
            dateFormat: "yy.mm.dd"
        });
    };

    this.updateBillingMethod = function () {
        $(document).on('click', '#btn-save-setting-billing', function () {
            let url = $(this).attr('data-url');
            // Set param to check currency id in server
            let param = {
                'current-url' : window.location.href,
                'billing-method-id' : $('#slb-billing-method').val(),
            }

            $.post(url, param, function (res) {
                console.log(res);
            });
        });
    };
};

/**
 *
 * @description event click button show popup add contract for all ship
 * @returns {undefined}
 */
$('#btn-add-contract-for-all-ship').on('click', function () {
    let url = $(this).attr('data-url');
    $.get(url, function (res) {
        if (res.code !== 200) {
            alert('Error');
            return;
        }

        $('#modal-protector').empty();
        $('#modal-protector').append(res.view);
        $('#modal-protector').modal('show');
        initSelect2();
        initDatePicker();
    })
})

/**
 *
 * @description event click button showw popup delete service for all ship
 * @returns {undefined}
 */
$('#btn-delete-service-for-all-ship').on('click', function () {
    let url = $(this).attr('data-url');
    $.get(url, function (res) {
        if (res.code !== 200) {
            alert('Error');
            return;
        }

        $('#delete-service-in-all-ship').empty();
        $('#delete-service-in-all-ship').append(res.view);
        $('#delete-service-in-all-ship').modal('show');
        $('#delete-service-in-all-ship').attr('style', 'display: block !important'); // setting css for modal display block
        // add perfect scroll for tbody
        const table = document.querySelector('.tbody-scroll');
        const ps = new PerfectScrollbar(table, function () {
            table.style.height = '200px'
        });
    });
});

/**
 *
 * @description event click show popup confirm for delete service in all ship
 */
$(document).on('click', '.delete-service-label', function (event) {
    let url = $('#' + event.target.getAttribute('id')).attr('data-url');

    $.get(url, function (res) {
        if (res.code !== 200) {
            alert('Error');
            return;
        }

        $('#popup-confirm-delete-service').empty();
        $('#popup-confirm-delete-service').append(res.view);
        $('#popup-confirm-delete-service').attr('style', 'display: block !important'); // setting css for modal display block
        $('#popup-stack-delete-service').attr('style', 'opacity: 0.5');
    });
});

/**
 * @description event close stack modal and remove opacity in behide modal
 */
$('#popup-confirm-delete-service').on('hide.bs.modal', function () {
    $('#popup-stack-delete-service').removeAttr('style');
});

/**
 *
 * @description event click show popup confirm for delete all contract in company
 */
$('#btn-delete-all-contract-company').on('click', function () {
    $('#popup-confirm-delete-all-contract').modal('show');
});

$(document).ready(function () {
    company.showSettingBillingMethod();
    company.updateBillingMethod();
});
