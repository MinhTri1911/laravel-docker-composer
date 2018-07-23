/**
 * File create ship contract js
 *
 * @package resources\assets\js
 * @author Rikkei.Trihnm
 * @date 2018/07/23
 */

const HTTP_SUCCESS = 200;
const HTTP_ERROR = 500;

var ship = new function () {
    this.models = {
        // Items
        nationId: '#search-nation-id',
        nationName: '#search-nation-name',
        tableAppenData: '#nation-data-scroll',
        txtNation: '#nation',
        txtNationId: '#nation-id',
        slbServieName: '#slb-service',
        txtChargeRegister: '#charge-register',
        txtChargeCreteData: '#charge-create-data',

        // Button
        seachNation: '#search-nation',
        btnSearchNation: '#btn-search-nation',
        btnOkeSelectNation: '#btn-ok',

        // Modal
        popupSeachNation: '#popup-search-nation',

        // Label
        lblPriceService: '#lbl-price-service',
    }

    this.data = {
        serviceData: JSON.parse($('#service-price').val()),
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
        }
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
            $(ship.models.txtChargeRegister).val(dataPrice.chargeRegister);
            $(ship.models.txtChargeCreteData).val(dataPrice.chargeCreateData);
            $(ship.models.lblPriceService).empty();
            $(ship.models.lblPriceService).append(dataPrice.price);
        });
    }
}

$(document).ready(function () {
    ship.initScrollForTable();
    ship.showSearchNation();
    ship.searchNation();
    ship.selectNation();
    ship.selectService();
});
