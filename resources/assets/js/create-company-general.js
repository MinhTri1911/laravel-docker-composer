/**
 * File create company js
 *
 * @package resources\assets\js
 * @author Rikkei.Trihnm
 * @date 2018/07/27
 */

const HTTP_SUCCESS = 200;
const HTTP_ERROR = 500;
const CHECK_NAME_JP = 0;
const CHECK_NAME_EN = 1;

var company = new function () {

    this.models = {
        // Items
        txtSearchCurrencyId: '#search-currency-id',
        txtSearchCurrencyCode: '#search-currency-code',
        txtSearchNationId: '#search-nation-id',
        txtSearchNationName: '#search-nation-name',
        txtTypeCompany: '#type-company',
        txtTypeShip: '#type-ship',
        txtCurrency: '#company-currency',
        txtCurrencyId: '#company-currency-id',
        sl2BillingMethod: '#slb-company-billing-method',
        txtNationNameCompany: '#company-nation',
        txtNationCompany: '#company-nation-id',
        txtNationNameShip: '#ship-nation',
        txtNationShip: '#ship-nation-id',
        txtCompanyNameJp: '#txt-company-name-jp',
        txtCompanyNameEn: '#txt-company-name-en',

        // Button
        btnSearchCurrency: '#btn-search-currency',
        btnSearchNation: '#btn-search-nation',
        btnOkeSelectCurrency: '#btn-currency-ok',
        btnOkeSelectNation: '#btn-ok',

        // Table append data
        tbodyAppendCurrency: '#currency-data-scroll',
        tbodyAppendNation: '#nation-data-scroll',

        // Label Error
        lblErrorSearchCurrency: '#lblErrorSearchCurrency',

        // Label warning
        lblWarningNameJp: '#lbl-warning-name-jp',
        lblWarningNameEn: '#lbl-warning-name-en',

        // Class error
        classAlertError: '.alert-danger',

        // Popup
        popupSearchCompanyNation: '#popup-company-search-nation',
        popupSearchShipNation: '#popup-ship-search-nation',

        // Div
        divSelect2BillingMethod: '#select2-billing-method',
    }

    this.urls = {
        urlSearchCurrency: $(this.models.btnSearchCurrency).attr('data-url'),
        urlSearchNation: $('#url-search-nation').val(),
        urlGetBillingByCurrency: $('#url-get-billing-method').val(),
        urlCheckNameCompany: $('#url-check-name-company').val(),
    }

    /**
     * Function search company nation
     */
    this.searchNationCompany = function () {
        ObjCommon.ajaxSearchCommon(
            this.models.popupSearchCompanyNation + ' ' + this.models.btnSearchNation,
            this,
            {
                url: this.urls.urlSearchNation,
                query: {
                    'search-nation-id': this.models.popupSearchCompanyNation + ' ' + this.models.txtSearchNationId,
                    'search-nation-name': this.models.popupSearchCompanyNation + ' ' + this.models.txtSearchNationName,
                    'search-type': this.models.txtTypeCompany,
                }
            }, function (data, parent) {
                $(parent.models.popupSearchCompanyNation + ' ' + parent.models.tbodyAppendNation).empty();
                $(parent.models.popupSearchCompanyNation + ' ' + parent.models.tbodyAppendNation).append(data.dataTable);
            }, function (data, parent) {
                return;
            }
        );
    }

    /**
     * Function search ship nation
     */
    this.searchNationShip = function () {
        ObjCommon.ajaxSearchCommon(
            this.models.popupSearchShipNation + ' ' + this.models.btnSearchNation,
            this,
            {
                url: this.urls.urlSearchNation,
                query: {
                    'search-nation-id': this.models.popupSearchShipNation + ' ' + this.models.txtSearchNationId,
                    'search-nation-name': this.models.popupSearchShipNation + ' ' + this.models.txtSearchNationName,
                    'search-type': this.models.txtTypeShip,
                }
            }, function (data, parent) {
                $(parent.models.popupSearchShipNation + ' ' + parent.models.tbodyAppendNation).empty();
                $(parent.models.popupSearchShipNation + ' ' + parent.models.tbodyAppendNation).append(data.dataTable);
            }, function (data, parent) {
                return;
            }
        );
    }

    /**
     * Function search currency
     */
    this.searchCurrency = function () {
        ObjCommon.ajaxSearchCommon(
            this.models.btnSearchCurrency,
            this,
            {
                url: this.urls.urlSearchCurrency,
                query: {
                    'currency-id': this.models.txtSearchCurrencyId,
                    'currency-code': this.models.txtSearchCurrencyCode,
                }
            }, function (data, parent) {
                // Setting css
                $(parent.models.classAlertError).css({'display': 'none'});

                // Append data
                $(parent.models.tbodyAppendCurrency).empty();
                $(parent.models.tbodyAppendCurrency).append(data.view);
            }, function (data, parent) {
                // Append message
                $(parent.models.lblErrorSearchCurrency).empty();
                $(parent.models.lblErrorSearchCurrency).append(data.error);

                // Setting css
                $(parent.models.classAlertError).css({'display': 'block'});
            }
        );
    }

    /**
     * Function choose currency and get billing
     */
    this.selectCurrnecy = function () {
        $(this.models.btnOkeSelectCurrency).bind('click', {company: this}, function (event) {
            let company = event.data.company;

            if ($("input:radio[name='choose-currency-id']:checked").val() != undefined) {
                let currencyCode = $("input:radio[name='choose-currency-id']:checked").attr('data-currency-code');
                let currencyId = $("input:radio[name='choose-currency-id']:checked").val();

                // Set name for text box currency
                $(company.models.txtCurrency).val(currencyCode);

                // Set id for text box currency id
                $(company.models.txtCurrencyId).val(currencyId);

                let query = {
                    'currencyId': currencyId
                }

                $.get(company.urls.urlGetBillingByCurrency, query, function (res) {
                    if (res.code === HTTP_SUCCESS) {
                        // Remove old option in billing method
                        $(company.models.sl2BillingMethod).html('');
                        let billings = JSON.parse(res.data.billing);

                        let index = 0;

                        // Setting new billing method after get by currency
                        for (var data in billings) {
                            var option = {
                                id: billings[data].id,
                                text: billings[data].name_jp
                            };

                            var newOption = new Option(option.text, option.id, false, false);

                            $(company.models.sl2BillingMethod).append(newOption).trigger('change');

                            if (index == 0) {
                                $(company.models.sl2BillingMethod + ' option[value=' + option.id + ']').attr('selected', 'selected');
                            }

                            index++;
                        }
                    }
                });
            }
        });
    }

    /**
     * Function select nation of company
     */
    this.selectNationCompany = function () {
        $(this.models.popupSearchCompanyNation + ' ' + this.models.btnOkeSelectNation).bind('click', {company: this},function (event) {
            let company = event.data.company;

            let nationId = $(company.models.popupSearchCompanyNation + " input[type='radio']:checked").val();
            let nationName = $(company.models.popupSearchCompanyNation + " input[type='radio']:checked").attr('data-nation-name');
            $(company.models.txtNationNameCompany).val(nationName);
            $(company.models.txtNationCompany).val(nationId);
        });
    }

    /**
     * Function select nation of ship
     */
    this.selectNationShip = function () {
        $(this.models.popupSearchShipNation + ' ' + this.models.btnOkeSelectNation).bind('click', {company: this},function (event) {
            let company = event.data.company;

            let nationId = $(company.models.popupSearchShipNation + " input[type='radio']:checked").val();
            let nationName = $(company.models.popupSearchShipNation + " input[type='radio']:checked").attr('data-nation-name');
            $(company.models.txtNationNameShip).val(nationName);
            $(company.models.txtNationShip).val(nationId);
        });
    }

    this.checkExistsNameCompany = function () {
        $(document).on('blur', this.models.txtCompanyNameJp, function (e) {
            let nameJp = $(this).val();

            if (nameJp != '' && nameJp !=  $(this).attr('data-name-remark')) {
                $.get($(this).attr('data-url'), {name: nameJp, type: CHECK_NAME_JP}, function (res) {
                    $(this).attr('data-name-remark', nameJp);

                    if (res.message[error][status].exists) {
                        $(company.models.lblWarningNameJp).empty();
                        $(company.models.lblWarningNameJp).append(res.message[error][status].message);
                    }
                });
            }
        });

        $(document).on('blur', this.models.txtCompanyNameEn, function (e) {
            let nameEn = $(this).val();

            if (nameEn != '' && nameEn !=  $(this).attr('data-name-remark')) {
                $.get($(this).attr('data-url'), {name: nameEn, type: CHECK_NAME_EN}, function (res) {
                    $(this).attr('data-name-remark', nameEn);

                    if (res.message[error][status].exists) {
                        $(company.models.lblWarningNameEn).empty();
                        $(company.models.lblWarningNameEn).append(res.message[error][status].message);
                    }
                });
            }
        });
    }
}

$(document).ready(function () {
    ObjCommon.initScrollForMultiTable([
        '#currency-data-scroll',
        '#popup-company-search-nation #nation-data-scroll',
        '#popup-ship-search-nation #nation-data-scroll'
    ]);
    company.searchCurrency();
    company.searchNationCompany();
    company.searchNationShip();
    company.selectCurrnecy();
    company.selectNationCompany();
    company.selectNationShip();
    company.checkExistsNameCompany();
});
