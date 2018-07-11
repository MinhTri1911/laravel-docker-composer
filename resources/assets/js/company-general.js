/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

const HTTP_SUCCESS = 200;
const HTTP_ERROR = 500;

var company = new function () {
    this.model = {
        selectModal: '#modal-protector',
        btnSaveSettingBilling: '#btn-save-setting-billing',
        lableNameBillingMethod: '#lbl-billing-method-id',
        labelError: '.alert-danger',
        labelShowMessage: '.lbl-error-message',
        btnShowSettingBilling: '#btn-setting-billing',
        btnAddServiceForAllShip: '#btn-add-service-for-all-ship',
        slbServiceId: '#slb-service-id',
        contractStartDate: '#contract-start-date',
        contractEndDate: '#contract-end-date',
        btnCreateContract: '#btn-create-contract',
    }

    this.url = {
        urlShowPopupSettingBillingMethod: $(this.model.btnShowSettingBilling).attr('data-url'),
        urlUpdateBillingMethod: window.Laravel.urlUpdateBillingMethod,
        urlShowPopupAddServiceForAllShip: $(this.model.btnAddServiceForAllShip).attr('data-url'),
        urlAddService: window.Laravel.urlAddService,
    }

    /**
     * Function click button setting billing show popup
     * @returns void
     */
    this.showSettingBillingMethod = function () {
        let companyObject = this;
        // Binding parameter to event click
        $('#btn-setting-billing').bind('click', {companyObject: companyObject}, function (event) {
            let url = event.data.companyObject.url.urlShowPopupSettingBillingMethod
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
            dateFormat: "yy/mm/dd"
        });
    };

    /**
     * Update billing method
     * @returns void
     */
    this.updateBillingMethod = function () {
        let companyObject = this;
        $(document).bind('click', {companyObject: companyObject}, function (event) {
            // Check if click to button update setting billing method
            if (('#' + event.target.getAttribute('id')) == event.data.companyObject.model.btnSaveSettingBilling) {
                let company = event.data.companyObject;

                // Set url for ajax update billing method
                let url = company.url.urlUpdateBillingMethod;

                // Set param to check currency id in server
                let param = {
                    'current-url' : window.location.href,
                    'billing-method-id' : $('#slb-billing-method').val(),
                }

                $.post(url, param, function (res) {
                    if (res.code === HTTP_SUCCESS) {
                        // Close Popup
                        $(company.model.selectModal).modal('toggle');

                        // Remove data in label billing method
                        $(company.model.lableNameBillingMethod).empty();

                        // Get data for append after update
                        let billings = $(company.model.btnSaveSettingBilling).attr('data-for-append');
                        let billingId = res.billingId;

                        // Append new value for billing method
                        $(company.model.lableNameBillingMethod).append(JSON.parse(billings)[billingId].jp);

                        // Replace new url for show popup
                        $(company.model.btnShowSettingBilling).attr('data-url', res.newShowUrl);

                        // Reset variable urlShowPopupSettingBillingMethod
                        company.url.urlShowPopupSettingBillingMethod = res.newShowUrl;
                    } else {
                        $(company.model.labelShowMessage).empty();
                        $(company.model.labelShowMessage).append(res.message);
                        $(company.model.selectModal + ' ' + company.model.labelError).css({'display': 'block'});
                    }
                });
            }
        });
    };

     /**
     * Function add service for all ship in company
     * @returns void
     */
    this.addServiceForAllShip = function () {
        let companyObject = this;
        $(this.model.btnAddServiceForAllShip).bind('click', {companyObject: companyObject}, function (event) {
            let company = event.data.companyObject;
            let url = company.url.urlShowPopupAddServiceForAllShip;

            let param = {
                'current-url': window.location.href,
            }

            $.get(url, param, function (res) {
                if (res.code == HTTP_SUCCESS) {
                    company.appendData(res.data.view);
                    company.initSelect2();
                    company.initDatePicker();
                }
            })
        })
    }

    // this.validationDateTimeCreateContract = function () {
    //     let companyObject = this;
    //     $(document).bind('change', {companyObject : companyObject}, function (event) {
    //         let company = event.data.companyObject
    //         let now1 = moment().format('L');
    //         let startDate = $(company.model.contractStartDate).val();
    //         let endDate = $(company.model.contractEndDate).val();
    //         let message = {

    //         }

    //         if (('#' + event.target.getAttribute('id')) == company.model.contractStartDate) {
    //             // Check if start date less than now
    //             if (!moment(startDate).isSameOrAfter(now1)) {
    //                 $(company.model.labelShowMessage).empty();
    //                 $(company.model.labelShowMessage).append('1');
    //                 $(company.model.selectModal + ' ' + company.model.labelError).css({'display': 'block'});

    //                 return;
    //             }

    //             if (endDate != undefined && !moment(startDate).isSameOrBefore(endDate)) {
    //                 $(company.model.labelShowMessage).empty();
    //                 $(company.model.labelShowMessage).append('2');
    //                 $(company.model.selectModal + ' ' + company.model.labelError).css({'display': 'block'});

    //                 return;
    //             }
    //         }

    //         if (('#' + event.target.getAttribute('id')) == company.model.contractEndDate) {
    //             // Check if end date less than now
    //             if (!moment(endDate).isSameOrAfter(now1)) {
    //                 $(company.model.labelShowMessage).empty();
    //                 $(company.model.labelShowMessage).append('3');
    //                 $(company.model.selectModal + ' ' + company.model.labelError).css({'display': 'block'});

    //                 return;
    //             }

    //             if ($(startDate).val() != undefined && !moment(startDate).isAfter(startDate)) {
    //                 $(company.model.labelShowMessage).empty();
    //                 $(company.model.labelShowMessage).append('4');
    //                 $(company.model.selectModal + ' ' + company.model.labelError).css({'display': 'block'});

    //                 return;
    //             }
    //         }

    //         if (moment(startDate).isSameOrAfter(now1) && moment(endDate).isAfter(startDate)) {
    //             $(company.model.selectModal + ' ' + company.model.labelError).css({'display': 'none'});

    //             return;
    //         }
    //     });
    // }

    this.addService = function () {
        let companyObject = this;
        $(document).bind('click', {companyObject: companyObject}, function (event) {
            let company = event.data.companyObject;
            if (('#' + event.target.getAttribute('id')) == company.model.btnCreateContract) {
                // Get url for post request add service
                let url = company.url.urlAddService;

                // Setting parameter
                let param = {
                    'service-id': $(company.model.slbServiceId).val(),
                    'start-date': $(company.model.contractStartDate).val(),
                    'end-date': $(company.model.contractEndDate).val(),
                    'current-url': window.location.href,
                }

                $.post(url, param, function (res) {
                    if (res.code == HTTP_SUCCESS) {

                    } else {
                        // Loop error messages
                        for (var message in res.message) {
                            // Append message error and show
                            $('.' + message).empty();
                            $('.' + message).append(res.message[message][0]);
                            $(company.model.selectModal + ' .alert-' + message).css({'display': 'block'});
                        }

                        // Reset css for alert message
                        $('.alert').css({'margin-bottom': '5px'});
                    }
                });
            }
        });
    }
};


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
    company.addServiceForAllShip();
    company.addService();
});
