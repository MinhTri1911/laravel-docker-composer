/**
 * File create company js
 *
 * @package resources\assets\js
 * @author Rikkei.Trihnm
 * @date 2018/07/27
 */

const HTTP_SUCCESS = 200;
const HTTP_ERROR = 500;

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

        // Button
        btnSearchCurrency: '#btn-search-currency',
        btnSearchNation: '#btn-search-nation',
        btnOkeSelectCurrency: '#btn-currency-ok',
        btnOkeSelectNation: '#btn-oke',

        // Table append data
        tbodyAppendCurrency: '#currency-data-scroll',
        tbodyAppendNation: '#nation-data-scroll',

        // Label Error
        lblErrorSearchCurrency: '#lblErrorSearchCurrency',

        // Class error
        classAlertError: '.alert-danger',

        // Popup
        popupSearchCompanyNation: '#popup-company-search-nation',
        popupSearchShipNation: '#popup-ship-search-nation',
    }

    this.urls = {
        urlSearchCurrency: $(this.models.btnSearchCurrency).attr('data-url'),
        urlSearchNation: $('#url-search-nation').val(),
        urlGetBillingByCurrency: $('#url-get-billing-method').val(),
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

    this.selectCurrency = function () {
        $(this.models.btnOkeSelectCurrency).bind('click', {company: this}, function (event) {
            console.log(123);
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
                    console.log(res);
                    if (res.code === HTTP_SUCCESS) {
                        console.log(JSON.parse(res.data.billing));
                        var openDiv = "<div class='form-input custom-select'>";
                        var openSelect = "<select class='form-control' tabindex='-1' name='slb-company-billing-method' aria-hidden='true'>";

                        var closeDiv = "</div>";
                        let str = '';
                        let billings = JSON.parse(res.data.billing);

                        for (var data in billings) {
                            str += "<option value=" + billings[data].id + ">" + billings[data].name_jp + "</option>"
                        }
                    }
                });
            }
        });
    }

    /**
     * Function search currency
     */
    this.getBilling = function () {

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
    company.selectCurrency();
});
