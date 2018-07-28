/**
 * File create ship contract js
 *
 * @package resources\assets\js
 * @author Rikkei.Trihnm
 * @date 2018/07/23
 */

const HTTP_SUCCESS = 200;
const HTTP_ERROR = 500;
const DATE_FORMAT = 'YYYY/MM/DD';
const MAX_LENGTH_REMARK = 255;
const MAX_LENGTH_CHARGE = 18;

var ship = new function () {
    this.flagValidator = true;

    this.serviceIdAdded = [];

    this.models = {
        // Items
        nationId: '#search-nation-id',
        nationName: '#search-nation-name',
        tableAppenData: '#nation-data-scroll',
        txtNation: '#nation',
        txtNationId: '#nation-id',
        slbServieName: '#slb-service',
        txtChargeRegister: '#charge-register',
        txtChargeCreateData: '#charge-create-data',
        txtStartDate: '#service-start-date',
        txtEndDate: '#service-end-date',
        txtRemark: '#txt-remark',
        areaPushService: '#service-data-hidden',

        // Button
        seachNation: '#search-nation',
        btnSearchNation: '#btn-search-nation',
        btnOkeSelectNation: '#btn-ok',
        btnAddService: '#btn-add-service-to-table',

        // Modal
        popupSeachNation: '#popup-search-nation',
        popupAddService: '#popup-add-service',

        // Label
        lblPriceService: '#lbl-price-service',
        lblErrorStartDate: '#lbl-error-start-date',
        lblErrorEndDate: '#lbl-error-end-date',
        lblErrorRemark: '#lbl-error-remark',
        lblErrorChargeRegister: '#lbl-error-charge-register',
        lblErrorChargeCreateData: '#lbl-error-charge-create-data',
        lblWarningDuplicate: '#warning-service-duplicate',

        // Table
        serviceAppendData: '#service-append-data',

        // class
        classErrorStartDate: '.error-start-date',
        classErrorEndDate: '.error-end-date',
        classErrorRemark: '.error-remark',
        classErrorChargeRegister: '.error-charge-register',
        classErrorChargeCreateData: '.error-charge-create-data',
        classSuccess: '.success-create-data',
        classErrorStartDateInput: '.service-start-date',
        classErrorEndDateInput: '.service-end-date',
        classErrorRemarkInput: '.txt-remark',
        classErrorSpotRegisterInput: '.charge-register',
        classErrorSpotCreateDataInput: '.charge-create-data',
    }

    this.data = {
        serviceData: JSON.parse($('#service-price').val()),
        messages: {
            startDateRequire: window.Laravel.startDateRequire,
            endDateRequire: window.Laravel.endDateRequire,
            startDateBeforNow: window.Laravel.startDateBeforNow,
            endDateBeforStartDate: window.Laravel.endDateBeforStartDate,
            startDateFormat: window.Laravel.startDateFormat,
            endDateFormat: window.Laravel.endDateFormat,
            remarkMaxLength: window.Laravel.remarkMaxLenght,
            chargeRegisterkMaxLength: window.Laravel.chargeRegisterMaxLength,
            chargeCreateDatakMaxLength: window.Laravel.chargeCreateDataMaxLength,
        },
    }

    this.urls = {
        urlSearchNation: $(this.models.btnSearchNation).attr('data-url'),
    }

    /**
     * Hanlde events
     */
    this.events = {
        /**
         * Event show popup
         * @param name
         * @return void
         */
        showPopup: function (name) {
            $(name).modal('show');
        },

        clickSeachNation: function () {
            $(document).on('click', this.models.btnSearchNation, function () {
                this.searchNation();
            })
        },

        /**
         * Event keyup then format number
         * @returns void
         */
        changeCharge: function () {
           $(document).on('keyup', ship.models.txtChargeRegister, function (event) {
               Events.separateComma($(this));
           });

           $(document).on('keyup', ship.models.txtChargeCreateData, function (event) {
               Events.separateComma($(this));
           });
        },

        /**
         * Event popup add service close
         * @return void
         */
        closeAddService: function () {
            $(document).on('hide.bs.modal', ship.models.popupAddService, function () {
                ship.clearMessageError();
            });
        },
    }

    /**
     * Format number to display
     * @param int|double number
     * @param int decimal
     * @return string
     */
    this.formatNumber = function (number) {
        return Events.separateCommaValue(number.toString());
    }

    /**
     * Function init for scroll height
     */
    this.initScrollForTable = function () {
        const table = document.querySelector('.tbody-scroll');
        const ps = new PerfectScrollbar(table, function () {
            table.style.height = '50px'
        });

        const tableNation = document.querySelector('#nation-data-scroll');
        const psNation = new PerfectScrollbar(tableNation, function () {
            tableNation.style.height = '500px'
        });
    }

    /**
     * Function show popup search nation
     */
    this.showSearchNation = function () {
        $(ship.models.seachNation).bind('click', {ship: this}, function () {
            ship.events.showPopup(ship.models.popupSeachNation);
        });
    }

    /**
     * Function search nation for create ship contract
     */
    this.searchNation = function () {
        $(document).bind('click', {ship: this}, function (event) {
            let ship = event.data.ship;

            if (ship.models.btnSearchNation == ('#' + event.target.getAttribute('id'))) {
                let query = {
                    'search-nation-id': $(ship.models.nationId).val(),
                    'search-nation-name': $(ship.models.nationName).val(),
                }

                $.get(ship.urls.urlSearchNation, query, function (res) {
                    if (res.code === HTTP_SUCCESS) {
                        $(ship.models.tableAppenData).empty();
                        $(ship.models.tableAppenData).append(res.data.dataTable);

                        const table = document.querySelector('#nation-data-scroll');
                        const ps = new PerfectScrollbar(table, function () {
                            table.style.height = '500px'
                        });
                    }
                })
                .fail(function (res) {
                    return;
                });
            }
        });
    }

    /**
     * Function select nation and fill to text box nation
     */
    this.selectNation = function () {
        $(ship.models.btnOkeSelectNation).on('click', function () {
            if ($("input:radio[name='choose-nation-id']:checked").val() != undefined) {
                let nationName = $("input:radio[name='choose-nation-id']:checked").attr('data-nation-name');
                let nationId = $("input:radio[name='choose-nation-id']:checked").val();

                // Set name for text box nation
                $(ship.models.txtNation).val(nationName);

                // Set id for text box nation id
                $(ship.models.txtNationId).val(nationId);
            }
        });
    }

    /**
     * Function reset value when select service
     */
    this.selectService = function () {
        $(ship.models.slbServieName).bind('change', {ship: this}, function (event) {
            let ship = event.data.ship;
            let dataPrice = ship.data.serviceData[$(this).val()];

            // Reset price service and price spot
            $(ship.models.txtChargeRegister).val(ship.formatNumber(dataPrice.chargeRegister));
            $(ship.models.txtChargeCreateData).val(ship.formatNumber(dataPrice.chargeCreateData));
            $(ship.models.lblPriceService).empty();
            $(ship.models.lblPriceService).append(ship.formatNumber(dataPrice.price));

            ship.clearMessageError();
        });
    }

    /**
     * Function validate adding service
     * @returns boolean
     */
    this.validatorService = function () {
        let startDate = $(ship.models.txtStartDate).val();
        let endDate = $(ship.models.txtEndDate).val();
        let now = moment().format('L');
        let remark = $(ship.models.txtRemark).val();
        let chargeRegister = $(ship.models.txtChargeRegister).val();
        let chargeCreateData = $(ship.models.txtChargeCreateData).val();

        // Check require start date
        if (startDate == '') {
            this.flagValidator = false;
            this.appendMessgeError(
                ship.models.classErrorStartDate,
                ship.models.lblErrorStartDate,
                ship.data.messages.startDateRequire
            );
            $(ship.models.classErrorStartDateInput).addClass('has-error');
        }

        // Check require end date
        if (endDate == '') {
            this.flagValidator = false;
            this.appendMessgeError(
                ship.models.classErrorEndDate,
                ship.models.lblErrorEndDate,
                ship.data.messages.endDateRequire
            );
            $(ship.models.classErrorEndDateInput).addClass('has-error');
        }

        // Check start date equal or after now
        if (startDate != '' && moment(startDate).isBefore(now)) {
            this.flagValidator = false;
            this.appendMessgeError(
                ship.models.classErrorStartDate,
                ship.models.lblErrorStartDate,
                ship.data.messages.startDateBeforNow
            );
            $(ship.models.classErrorStartDateInput).addClass('has-error');
        }

        // Check end date after start date
        if (startDate != '' && moment(endDate).isSameOrBefore(startDate)) {
            this.flagValidator = false;
            this.appendMessgeError(
                ship.models.classErrorEndDate,
                ship.models.lblErrorEndDate,
                ship.data.messages.endDateBeforStartDate
            );
            $(ship.models.classErrorEndDateInput).addClass('has-error');
        }

        // Check start date, end date valid format
        if (this.flagValidator) {
            // Check format startdate
            let checkFormatStartDate = moment(startDate, DATE_FORMAT, true);
            let isValidStartDate = checkFormatStartDate.isValid();

            let checkFormatEndDate = moment(endDate, DATE_FORMAT, true);
            let isValidEndDate = checkFormatEndDate.isValid();

            if (!isValidStartDate) {
                this.flagValidator = false;
                this.appendMessgeError(
                    ship.models.classErrorStartDate,
                    ship.models.lblErrorStartDate,
                    ship.data.messages.startDateFormat
                );
                $(ship.models.classErrorStartDateInput).addClass('has-error');
            }

            if (!isValidEndDate) {
                this.flagValidator = false;
                this.appendMessgeError(
                    ship.models.classErrorEndDate,
                    ship.models.lblErrorEndDate,
                    ship.data.messages.endDateFormat
                );
                $(ship.models.classErrorEndDateInput).addClass('has-error');
            }
        }

        // Check max length remark
        if (remark.length > MAX_LENGTH_REMARK) {
            this.flagValidator = false;
            this.appendMessgeError(
                ship.models.classErrorRemark,
                ship.models.lblErrorRemark,
                ship.data.messages.remarkMaxLength
            );
            $(ship.models.classErrorRemarkInput).addClass('has-error');
        }

        // Check max length charge register
        if (chargeRegister.length > MAX_LENGTH_CHARGE) {
            this.flagValidator = false;
            this.appendMessgeError(
                ship.models.classErrorChargeRegister,
                ship.models.lblErrorChargeRegister,
                ship.data.messages.chargeRegisterkMaxLength
            );
            $(ship.models.classErrorSpotRegisterInput).addClass('has-error');
        }

        // Check max length charge create data
        if (chargeCreateData.length > MAX_LENGTH_CHARGE) {
            this.flagValidator = false;
            this.appendMessgeError(
                ship.models.classErrorChargeCreateData,
                ship.models.lblErrorChargeCreateData,
                ship.data.messages.chargeCreateDatakMaxLength
            );
            $(ship.models.classErrorSpotCreateDataInput).addClass('has-error');
        }

        let statusReturn = this.flagValidator;

        // Reset flag check status
        this.flagValidator = true;

        return statusReturn;
    }

    /**
     * Function append message error
     * @param string classAppend
     * @param string label
     * @param string message
     * @returns void
     */
    this.appendMessgeError = function (classAppend, label, message) {
        // Append message error
        $(label).empty();
        $(label).append(message);

        $(classAppend).css({'display': 'block'});
    }

    /**
     * Function clear message error
     * @returns void
     */
    this.clearMessageError = function () {
        $(ship.models.lblErrorStartDate).empty();
        $(ship.models.classErrorStartDate).css({'display': 'none'});

        $(ship.models.lblErrorEndDate).empty();
        $(ship.models.classErrorEndDate).css({'display': 'none'});

        $(ship.models.lblErrorRemark).empty();
        $(ship.models.classErrorRemark).css({'display': 'none'});

        $(ship.models.lblErrorChargeRegister).empty();
        $(ship.models.classErrorChargeRegister).css({'display': 'none'});

        $(ship.models.lblErrorChargeCreateData).empty();
        $(ship.models.classErrorChargeCreateData).css({'display': 'none'});

        $(ship.models.classSuccess).css({'display': 'none'});

        $(ship.models.lblWarningDuplicate).css({'display': 'none'});

        // Remove class hight light error
        $(ship.models.classErrorStartDateInput).removeClass('has-error');
        $(ship.models.classErrorEndDateInput).removeClass('has-error');
        $(ship.models.classErrorRemarkInput).removeClass('has-error');
        $(ship.models.classErrorSpotRegisterInput).removeClass('has-error');
        $(ship.models.classErrorSpotCreateDataInput).removeClass('has-error');
    }

    /**
     * Function add service to table
     * @returns void
     */
    this.addService = function () {
        $(ship.models.btnAddService).bind('click', {ship: this}, function (event) {
            let ship = event.data.ship;

            if (('#') + event.target.getAttribute('id') == ship.models.btnAddService) {
                // First clear old message
                ship.clearMessageError();

                // Check validator
                if (!ship.validatorService()) {
                    return;
                } else {
                    if (!ship.serviceIdAdded.includes($(ship.models.slbServieName).val())) {
                    // Set value for append
                        let beginTd = '<td class="col-md-2">';
                        let endTd = '</td>';
                        let beginTr = '<tr>';
                        let endTr = '</tr>';

                        let data = {
                            serviceId: $(ship.models.slbServieName).val(),
                            serviceName: $(ship.models.slbServieName).find('option:selected').text(),
                            version: '1,0',
                            price: ship.data.serviceData[$(ship.models.slbServieName).val()].price,
                            startDate: $(ship.models.txtStartDate).val(),
                            endDate: $(ship.models.txtEndDate).val(),
                        }

                        let str = '';

                        // Loop for adding string
                        for (var append in data) {
                            str += (beginTd + data[append] + endTd);
                        }

                        // Add id service to remark service was added
                        ship.serviceIdAdded.push(data.serviceId);

                        // Append dataa
                        $(ship.models.serviceAppendData).append(beginTr + str + endTr);

                        // Show messsage success
                        $(ship.models.classSuccess).css({'display': 'block'});

                        let dataAppend = {
                            serviceId: $(ship.models.slbServieName).val(),
                            startDate: $(ship.models.txtStartDate).val(),
                            endDate: $(ship.models.txtEndDate).val(),
                            remark: $(ship.models.txtRemark).val(),
                            spotRegisterId: $(ship.models.txtChargeRegister).attr('data-id'),
                            chargeRegister: $(ship.models.txtChargeRegister).val(),
                            spotCreateDataId: $(ship.models.txtChargeCreateData).attr('data-id'),
                            chargeCreateData: $(ship.models.txtChargeCreateData).val(),
                        }

                        $(ship.models.areaPushService).append(ship.appendFormHidden(dataAppend));
                    } else {
                        $(ship.models.lblWarningDuplicate).css({'display': 'block'});
                    }
                }
            }
        });
    }

    this.appendFormHidden = function (data) {

        let formService = "<input type='hidden' name='service[" + data.serviceId + "]' value='" + data.serviceId + "'>";
        let formServiceId = "<input type='hidden' name=service[" + data.serviceId + "][id] value='" + data.serviceId + "'>";
        let formStartDate = "<input type='hidden' name=service[" + data.serviceId + "][start-date] value='" + data.startDate + "'>";
        let formEndDate = "<input type='hidden' name=service[" + data.serviceId + "][end-date] value='" + data.endDate + "'>";
        let formRemark = "<input type='hidden' name=service[" + data.serviceId + "][remark] value='" + data.remark + "'>";

        let formSpotRegister = "<input type='hidden' name='spot[" + data.serviceId + "]"
            + "[" + data.spotRegisterId + "]' value='" + data.spotRegisterId + "'>";
        let formSpotRegisterId = "<input type='hidden' name=spot[" + data.serviceId + "]"
            + "[" + data.spotRegisterId + "][id] value='" + data.spotRegisterId + "'>";
        let formSpotChargeRegister = "<input type='hidden' name=spot[" + data.serviceId + "]"
            + "[" + data.spotRegisterId + "][charge] value='" + data.chargeRegister + "'>";

        let formSpotCreateData = "<input type='hidden' name=spot[" + data.serviceId + "]"
            + "[" + data.spotCreateDataId + "] value='" + data.spotCreateDataId + "'>";
        let formSpotCreateDataId = "<input type='hidden' name=spot[" + data.serviceId + "]"
            + "[" + data.spotCreateDataId + "][id] value='" + data.spotCreateDataId + "'>";
        let formSpotChargeCreateData = "<input type='hidden' name=spot[" + data.serviceId + "]"
            + "[" + data.spotCreateDataId + "][charge] value='" + data.chargeCreateData + "'>";

        let str = (formService + formServiceId + formStartDate + formEndDate + formRemark + formSpotRegister);
        str += (formSpotRegisterId + formSpotChargeRegister + formSpotCreateData + formSpotCreateDataId +formSpotChargeCreateData);

        return str;
    }
}

$(document).ready(function () {
    ship.initScrollForTable();
    ship.events.changeCharge();
    ship.showSearchNation();
    ship.searchNation();
    ship.selectNation();
    ship.selectService();
    ship.addService();
    ship.events.closeAddService();
});
