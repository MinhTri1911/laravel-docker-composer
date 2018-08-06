const HTTP_SUCCESS = 200;

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
        seachNation: '.search-nation',
        btnSearchNation: '#btn-search-nation',
        btnOkeSelectNation: '#btn-ok',

        // Modal
        popupSeachNation: '#popup-search-nation',

        // Label
        lblPriceService: '#lbl-price-service',
    };

    this.urls = {
        urlSearchNation: $(this.models.btnSearchNation).attr('data-url'),
    };

    /**
     * Handle events
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
    };

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
    };

    /**
     * Function show popup search nation
     */
    this.showSearchNation = function () {
        $(ship.models.seachNation).bind('click', {ship: this}, function () {
            ship.events.showPopup(ship.models.popupSeachNation);
        });
    };

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
                    'search-type': 'ship',
                };

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
                    return false;
                });
            }
        });
    };

    /**
     * Function select nation and fill to text box nation
     */
    this.selectNation = function () {
        $(ship.models.btnOkeSelectNation).on('click', function () {
            var nationId = $(ship.models.popupSeachNation + " input[type='radio']:checked").val();
            var nationName = $(ship.models.popupSeachNation + " input[type='radio']:checked").attr('data-nation-name');

            if (nationId !== undefined) {
                // Set name for text box nation
                $(ship.models.txtNation).val(nationName);
                // Set id for text box nation id
                $(ship.models.txtNationId).val(nationId);
            }
        });

        $(ship.models.seachNation).on('click', function () {
            if ($(ship.models.txtNationId).val() !== '') {
                let nationId = "#choose-nation-id-" + $(ship.models.txtNationId).val() + '-ship';
                $(nationId).prop("checked", true);
            }
        });
    }
};

$(document).ready(function () {
    ship.initScrollForTable();
    ship.showSearchNation();
    ship.searchNation();
    ship.selectNation();
});
