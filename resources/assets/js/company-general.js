/**
 * File company general js
 *
 * @package resources\assets\js
 * @author Rikkei.Trihnm
 * @date 2018/07/11
 */

const HTTP_SUCCESS = 200;
const HTTP_ERROR = 500;

var company = new function () {
    this.model = {
        companyId: $('#company-id').val(),

        // Modal id
        selectModal: '#modal-protector',
        popupShowAllService: '#delete-service-in-all-ship',
        popupConfirmDeleteService: '#popup-confirm-delete-service',
        popupDeleteAllService: '#popup-delete-all-service',
        popupConfirmDeleteCompany: '#modal-confirm',
        popupDeleteCompanyDone: '#modal-done',
        popupModalAuth: '#modal-auth',
        modalStackShowAllService: '#modal-stack-one',
        modalShowMessAction: '#modal-show-message-action',

        // Button action
        btnSaveSettingBilling: '#btn-save-setting-billing',
        btnShowPopupDeleteAllService: '#btn-show-popup-delete-all-service',
        btnDeleteAllService: '#btn-delete-all-service',
        btnCreateContract: '#btn-create-contract',
        btnShowPopupDeleteServiceInAllShip: '#btn-show-popup-delete-service-in-all-ship',
        btnDeleteService: '#btn-delete-service',
        btnShowSettingBilling: '#btn-setting-billing',
        btnAddServiceForAllShip: '#btn-add-service-for-all-ship',
        btnShowPopupConfirmDeleteCompany: '#btn-show-popup-confirm-delete-company',
        btnAccpetDeleteCompany: '#modalBtnOK',
        btnEnterPassword: '#modalBtnOKAuth',

        // Item
        lableNameBillingMethod: '#lbl-billing-method-id',
        labelError: '.alert-danger',
        labelSuccess: '.alert-success',
        labelInfo: '.alert-info',
        labelShowMessage: '.lbl-error-message',
        lblDeleteService: '.delete-service-label',
        h4TitleShowMessAction: '#modal-title-message-action',
        txtMessAction: '#message-action',

        // Form input
        txtPassword: '#pw-user',
        slbServiceId: '#slb-service-id',
        contractStartDate: '#contract-start-date',
        contractEndDate: '#contract-end-date',

        // Type message
        typeError: 'error',
        typeSuccess: 'success',
        typeInfo: 'info',
    }

    // Url hanlde
    this.url = {
        urlShowPopupSettingBillingMethod: $(this.model.btnShowSettingBilling).attr('data-url'),
        urlUpdateBillingMethod: window.Laravel.urlUpdateBillingMethod,
        urlShowPopupAddServiceForAllShip: $(this.model.btnAddServiceForAllShip).attr('data-url'),
        urlAddService: window.Laravel.urlAddService,
        urlShowPopupGetAllService: $(this.model.btnShowPopupDeleteServiceInAllShip).attr('data-url'),
        urlDeleteServiceInAllShip: window.Laravel.urlDeleteServiceInAllShip,
        urlDeleteAllService: $(this.model.btnDeleteAllService).attr('data-url'),
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
                'company-id' : company.model.companyId,
            }

            $.get(url, param, function (res) {
                if (res.code === HTTP_SUCCESS) {
                    event.data.companyObject.appendData(res.data.view);
                    event.data.companyObject.initSelect2();
                }
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
                    'company-id' : company.model.companyId,
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
                        let billingId = res.data.billingId;

                        // Append new value for billing method
                        $(company.model.lableNameBillingMethod).append(JSON.parse(billings)[billingId].jp);

                        // Replace new url for show popup
                        $(company.model.btnShowSettingBilling).attr('data-url', res.data.newShowUrl);

                        // Reset variable urlShowPopupSettingBillingMethod
                        company.url.urlShowPopupSettingBillingMethod = res.data.newShowUrl;
                    }
                })
                .fail(function (res) {
                    for (var message in res.responseJSON.errors) {
                        $(company.model.labelShowMessage).empty();
                        $(company.model.labelShowMessage).append(res.responseJSON.errors[message][0]);
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
    this.showPopupAddServiceForAllShip  = function () {
        let companyObject = this;
        $(this.model.btnAddServiceForAllShip).bind('click', {companyObject: companyObject}, function (event) {
            let company = event.data.companyObject;
            let url = company.url.urlShowPopupAddServiceForAllShip;

            let param = {
                'company-id': company.model.companyId,
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

    /**
     * Function add service for all ship in company
     * @returns void
     */
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
                    'company-id': company.model.companyId,
                }

                $.post(url, param, function (res) {
                    if (res.code == HTTP_SUCCESS) {
                        // Show popup message
                        company.showPopUpMessAction(res.message, company.model.selectModal);
                    }
                })
                .fail(function(res) {
                    // Loop error messages
                    for (var message in res.responseJSON.errors) {
                        // Append message error and show
                        $('.' + message).empty();
                        $('.' + message).append(res.responseJSON.errors[message][0]);
                        $(company.model.selectModal + ' .alert-' + message).css({'display': 'block'});
                    }

                    // Reset css for alert message
                    $('.alert').css({'margin-bottom': '5px'});
                });
            }
        });
    }

    /**
     * Function show popup get all service in company
     * @returns void
     */
    this.showPopupAllServiceInCompany = function () {
        let companyObeject = this;
        $(this.model.btnShowPopupDeleteServiceInAllShip).bind('click', {companyObeject: companyObeject}, function (event) {
            let company = event.data.companyObeject;
            let url = company.url.urlShowPopupGetAllService;
            let param = {
                'company-id': company.model.companyId
            }

            $.get(url, param, function (res) {
                if (res.code === HTTP_SUCCESS) {

                    $(company.model.popupShowAllService).empty();
                    $(company.model.popupShowAllService).append(res.data.view);
                    $(company.model.popupShowAllService).modal('show');

                    // setting css for modal display block
                    $(company.model.popupShowAllService).attr('style', 'display: block !important');

                    // add perfect scroll for tbody
                    const table = document.querySelector('.tbody-scroll');
                    const ps = new PerfectScrollbar(table, function () {
                        table.style.height = '200px'
                    });
                }
            });
        });
    }

    /**
     * Function confirm delete service in all ship
     * @return void
     */
    this.confirmDeleteServiceInAllShip = function () {
        let companyObject = this;
        $(document).bind('click', {companyObject: companyObject}, function (event) {
            if (('.' + event.target.getAttribute('class')) === company.model.lblDeleteService) {
                let company = event.data.companyObject;
                let url = $('#' + event.target.getAttribute('id')).attr('data-url');

                $.get(url, function (res) {
                    if (res.code === HTTP_SUCCESS) {
                        // Append data
                        $(company.model.popupConfirmDeleteService).empty();
                        $(company.model.popupConfirmDeleteService).append(res.data.view);

                        // setting css for modal display block
                        $(company.model.popupConfirmDeleteService).attr('style', 'display: block !important');
                        $(company.model.modalStackShowAllService).attr('style', 'opacity: 0.5');
                    }
                })
                .fail(function (res) {
                    return;
                });
            }
        });
    }

    /**
     * Function delete service in all ship
     */
    this.deleteServiceInAllShip = function () {
        let companyObject = this;

        $(document).bind('click', {companyObject: companyObject}, function (event) {
            let company = event.data.companyObject;

            if (('#' + event.target.getAttribute('id')) == company.model.btnDeleteService) {
                let url = company.url.urlDeleteServiceInAllShip;
                let param = {
                    'service-ids': $(company.model.btnDeleteService).attr('data-id'),
                    'company-id': company.model.companyId,
                }

                $.post(url, param, function (res) {
                    if (res.code === HTTP_SUCCESS) {
                        // Close popup
                        $('#popup-confirm-delete-service').modal('toggle');

                        // Show message success
                        $(company.model.labelSuccess).find('label').empty();
                        $(company.model.labelSuccess).find('label').append(res.message);
                        $(company.model.labelSuccess).css({'display': 'block'});

                        // Setting after 5 seconds is hidden
                        window.setTimeout(function () {
                            $(company.model.labelSuccess).css({'display': 'none'});
                        }, 5000);
                    }
                })
                .fail(function (res) {
                    return;
                });
            }
        });
    }

    /**
     * Function show popup confirm delete all service in company
     */
    this.showPopupDelelteAllService = function () {
        let companyObject = this;

        $(this.model.btnShowPopupDeleteAllService).bind('click', {companyObject: companyObject}, function (event) {
            let company = event.data.companyObject;
            $(company.model.labelShowMessage).empty();

            // Hidden label error
            $(company.model.labelError).css({'display': 'none'});

            // Hidden label success
            $(company.model.labelSuccess).css({'display': 'none'});

            // Hidden label info
            $(company.model.labelInfo).css({'display': 'none'});

            $(company.model.popupDeleteAllService).modal('show');
        });
    }

    /**
     * Function delete all service in company
     */
    this.delelteAllService = function () {
        let companyObject = this;

        $(document).bind('click', {companyObject: companyObject}, function (event) {
            let company = event.data.companyObject;
            if (('#' + event.target.getAttribute('id')) === company.model.btnDeleteAllService) {
                let url = company.url.urlDeleteAllService;
                let param = {
                    'company-id': company.model.companyId,
                }

                $.post(url, param, function (res) {
                    if (res.code === HTTP_SUCCESS) {
                        // Show popup message
                        company.showPopUpMessAction(res.message, company.model.popupDeleteAllService);
                    } else {
                        //Append error message
                        for (var error in res.message) {
                            $(company.model.labelShowMessage).empty();
                            $(company.model.labelShowMessage).append(res.message[error]);
                        }

                        // Show error
                        $(company.model.labelError).css({'display': 'block'});

                        return;
                    }
                })
                .fail(function (res) {
                    return;
                });
            }

        });
    }

    /**
     * Function show popup message after do action
     */
    this.showPopUpMessAction = function (mess, popupClose) {
        $(this.model.txtMessAction).empty();
        $(this.model.txtMessAction).append(mess);
        $(popupClose).modal('toggle');
        $(this.model.modalShowMessAction).modal('show');
    }

    /**
     * Function show popup confirm delete company
     */
    this.showPopupConfirmDeleteCompany = function () {
        let companyObject = this;
        $(this.model.btnShowPopupConfirmDeleteCompany).bind('click', {companyObject: companyObject}, function (event) {
            let company = event.data.companyObject;

            // Show popup confirm
            $(company.model.popupConfirmDeleteCompany).modal('show');
        });
    }

    /**
     * Function show popup verify password user
     */
    this.showPopupEnterPassword = function () {
        let companyObject = this;
        $(document).bind('click', {companyObject: companyObject}, function (event) {
            let company = event.data.companyObject;

            if (('#' + event.target.getAttribute('id')) === company.model.btnAccpetDeleteCompany) {
                $(company.model.labelShowMessage).empty();

                // Hidden label error
                $(company.model.labelError).css({'display': 'none'});

                $(company.model.popupConfirmDeleteCompany).modal('toggle');
                $(company.model.popupModalAuth).modal('show');
            }
        });
    }

    /**
     * Function delete company
     */
    this.enterPasswordDeleteCompany = function () {
        let companyObject = this;
        $(document).bind('click', {companyObject: companyObject}, function (event) {
            let company = event.data.companyObject;

            if (('#' + event.target.getAttribute('id')) === company.model.btnEnterPassword) {
                let url = $(company.model.btnEnterPassword).attr('data-url');
                let param = {
                    'password': $(company.model.txtPassword).val(),
                    'company-id': company.model.companyId,
                }

                $.post(url, param, function (res) {
                    if (res.code === HTTP_SUCCESS) {
                        // Hidden modal verify password
                        $(company.model.popupModalAuth).modal('toggle');

                        // Show popup alert delete done
                        $(company.model.popupDeleteCompanyDone).modal('show');

                        // Set timeout for redirect with 5 seconds
                        window.setTimeout(function() {
                            window.location.href = $(company.model.btnEnterPassword).attr('data-redirect');
                        }, 5000);
                    } else {
                        //Append error message
                        for (var error in res.message) {
                            $(company.model.labelShowMessage).empty();
                            $(company.model.labelShowMessage).append(res.message[error]);
                        }

                        // Show error
                        $(company.model.labelError).css({'display': 'block'});

                        return;
                    }
                })
                .fail(function (res) {
                    //Append error message
                    for (var error in res.responseJSON.errors) {
                        $(company.model.labelShowMessage).empty();
                        $(company.model.labelShowMessage).append(res.responseJSON.errors[error][0]);
                    }

                    // Show error
                    $(company.model.labelError).css({'display': 'block'});
                });
            }
        });
    }

    /**
     * Function close stack modal and remove opacity in behide modal
     */
    this.hiddenModalStack = function () {
        $(company.model.popupConfirmDeleteService).on('hide.bs.modal', function () {
            // Remove attribute style in modal
            $(company.model.modalStackShowAllService).removeAttr('style');
        });
    }

    /**
     * Function close modal verify password user
     */
    this.hiddenModalAuth = function () {
        $(company.model.popupModalAuth).on('hide.bs.modal', function () {
            $(company.model.txtPassword).val('');

            // Hidden error
            $(company.model.labelShowMessage).empty();
            $(company.model.labelError).css({'display': 'none'});
        });
    }

    /**
     * Function focus enter password
     */
    this.focusEnterPassword = function () {
        $(company.model.txtPassword).on('change', function () {
            let input = document.getElementById('pw-user');

            input.addEventListener("keyup", function (event) {
                event.preventDefault();

                // Check event enter
                if (event.keyCode === 13) {
                    document.getElementById('modalBtnOKAuth').click();
                }
            });
        });
    }
};

$(document).ready(function () {
    company.showSettingBillingMethod();
    company.updateBillingMethod();
    company.showPopupAddServiceForAllShip();
    company.addService();
    company.showPopupAllServiceInCompany();
    company.confirmDeleteServiceInAllShip();
    company.hiddenModalStack();
    company.deleteServiceInAllShip();
    company.showPopupDelelteAllService();
    company.delelteAllService();
    company.showPopupConfirmDeleteCompany();
    company.showPopupEnterPassword();
    company.enterPasswordDeleteCompany();
    company.hiddenModalAuth();
    company.focusEnterPassword();
});
