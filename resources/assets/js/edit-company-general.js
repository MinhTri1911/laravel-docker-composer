/**
 * File create company js
 *
 * @package resources\assets\js
 * @author Rikkei.Trihnm
 * @date 2018/08/03
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
        txtCurrency: '#company-currency',
        txtCurrencyId: '#company-currency-id',
        sl2BillingMethod: '#slb-company-billing-method',
        txtNationNameCompany: '#company-nation',
        txtNationCompany: '#company-nation-id',
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

        // Label error
        lblErrorSearchCurrency: '#lblErrorSearchCurrency',

        // Class error
        classAlertError: '.alert-danger',
        classAlertWarning: '.alert-warning',
        classAppendMessWarning: '.append-message',

        // Popup
        popupSearchCompanyNation: '#popup-company-search-nation',
        popupSearchCurrency: '#popup-company-search-currency',

        // Div
        divSelect2BillingMethod: '#select2-billing-method',
        divSearchNation: '#search-nation',
        divSearhcCurrency: '#search-currency',
    }

    this.urls = {
        urlSearchCurrency: $(this.models.btnSearchCurrency).attr('data-url'),
        urlSearchNation: $('#url-search-nation').val(),
        urlGetBillingByCurrency: $('#url-get-billing-method').val(),
    }

    /**
     * Function init page set nation and currency is checked
     */
    this.init = function () {
        $(this.models.divSearchNation).on('click', function () {
            if ($(company.models.txtNationCompany).val() !== '') {
                let nationId = "#choose-nation-id-" + $(company.models.txtNationCompany).val() + '-company';
                $(nationId).prop("checked", true);
            }
        });

        $(this.models.divSearhcCurrency).on('click', function () {
            if ($(company.models.txtCurrencyId).val() !== '') {
                let currencyId = "#choose-currency-id-" + $(company.models.txtCurrencyId).val();
                $(currencyId).prop("checked", true);
            }
        });
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

            if (nationId != undefined && nationName != undefined) {
                $(company.models.txtNationNameCompany).val(nationName);
                $(company.models.txtNationCompany).val(nationId);
            }
        });
    }

    /**
     * Function check duplicate name company
     */
    this.checkDuplicate = function () {
        $(this.models.txtCompanyNameEn).on('blur', function () {
            let nameEn = $(company.models.txtCompanyNameEn).val();

            if (nameEn != '' && nameEn != $(company.models.txtCompanyNameEn).attr('data-name-remark')) {
                $(company.models.txtCompanyNameEn).attr('data-name-remark', nameEn);
                let query = {
                    'nameEn': nameEn,
                    'nameJp': $(company.models.txtCompanyNameJp).val(),
                    'typeCheck': 'update',
                    'companyId': $(company.models.txtCompanyNameEn).attr('data-company-id')
                }

                // Check exists
                $.post($(company.models.txtCompanyNameEn).attr('data-url'), query, function (res) {
                    if (res.code === HTTP_SUCCESS) {
                        // Append message warning
                        $(company.models.classAppendMessWarning).empty();
                        $(company.models.classAppendMessWarning).append(res.data.html);
                    }
                })
                .fail(function (res) {
                    return;
                })
            }

            // Reset if value is null
            if (nameEn == '') {
                $(company.models.txtCompanyNameEn).attr('data-name-remark', '');
            }
        });

        $(this.models.txtCompanyNameJp).on('blur', function () {
            let nameJp = $(company.models.txtCompanyNameJp).val();

            if (nameJp != '' && nameJp != $(company.models.txtCompanyNameJp).attr('data-name-remark')) {
                $(company.models.txtCompanyNameJp).attr('data-name-remark', nameJp);
                let query = {
                    'nameEn':  $(company.models.txtCompanyNameEn).val(),
                    'nameJp': nameJp,
                    'typeCheck': 'update',
                    'companyId': $(company.models.txtCompanyNameJp).attr('data-company-id')
                }

                // Check exists
                $.post($(company.models.txtCompanyNameJp).attr('data-url'), query, function (res) {
                    if (res.code === HTTP_SUCCESS) {
                        // Append message warning
                        $(company.models.classAppendMessWarning).empty();
                        $(company.models.classAppendMessWarning).append(res.data.html);
                    }
                })
                .fail(function (res) {
                    return;
                })
            }

            // Reset if value is null
            if (nameJp == '') {
                $(company.models.txtCompanyNamejp).attr('data-name-remark', '');
            }
        });
    }
}

$(document).ready(function () {
    ObjCommon.initScrollForMultiTable([
        '#currency-data-scroll',
        '#popup-company-search-nation #nation-data-scroll'
    ]);
    company.init();
    company.searchCurrency();
    company.searchNationCompany();
    company.selectCurrnecy();
    company.selectNationCompany();
    company.checkDuplicate();
});
