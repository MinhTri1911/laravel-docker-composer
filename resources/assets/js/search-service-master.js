var searchService = new function () {

    this.models = {
        // Check current screen is edit contract
        isUpdate: false,
        // Check if user select other service
        isChangeService: false,
        // Initial current service id
        oldService: null,
        // DOM Element content search service
        contentSearch: "#content-data-search",
        shipId: "input[name=shipId]",
        currencyId: "input[name=currencyId]",
        btnOk: "#btn-ok",
        btnSearch: "#btn-search",
        inputIdService: "input[name=idService]",
        inputIdServiceSearch: "input[name=idServiceSearch]",
        inputNameServiceSearch: "input[name=nameServiceSearch]",
        showModalService: ".show-modal-service",
        chargeRegister: "input[name=chargeRegister]",
        chargeCreate: "input[name=chargeCreate]",
        shipIdHidden : "input[name=shipIdHidden]",
        serviceIdHidden : "input[name=serviceIdHidden]",
        serviceIdOld : "input[name=serviceIdOld]",
        // DOM Element of spot section
        elSpotBlock: ".spot-block",
        initElSpotBlock: ''
    },
    this.init = function () {

        //searchService.events.load();

        $(document).on('click', searchService.models.btnOk, function (e) {
            searchService.events.chosseValue();
        });

        $(document).on('click', searchService.models.btnSearch, function (e) {
            searchService.events.search();
        });

        $(document).on('click', searchService.models.showModalService, function (e) {
            searchService.events.load();
        });

        var serviceHidden = $(searchService.models.serviceIdHidden).val();

        searchService.models.initElSpotBlock = $(searchService.models.elSpotBlock).html();

        if (typeof serviceHidden != "undefined" && serviceHidden !== '' && !isNaN(serviceHidden)) {
            searchService.models.isUpdate = true;
            searchService.models.oldService = serviceHidden;
        }
    };

    this.events = {

        load: function () {

            $(searchService.models.contentSearch).empty();

            var url = location.protocol + "//" + location.host + '/search/service/' + 'init';

            var shipId = ($(searchService.models.shipIdHidden).length > 0)
                            ?$(searchService.models.shipIdHidden).val()
                            :$(searchService.models.shipId).val();
            var currencyId = $(searchService.models.currencyId).val();
            var serviceIdOld = $(searchService.models.serviceIdOld).val()||null;

            if (currencyId != null) {

                // Handle ajax send data to server
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "shipId": shipId,
                        "currencyId": currencyId,
                        "serviceId": serviceIdOld,
                        "_token": App.getToken()
                    },
                    success: function (data) {
                        searchService.events.updateContentByData(data);
                    },
                    // Not do anything when error
                    error: function (error) {
                        return false;
                    }
                });

            } else {
                $(searchService.models.contentSearch).empty();
            }

            return;
        },

        /**
         * Initial html for spot section
         * 
         * @param SearchService.registCharge.value registCharge
         * @param SearchService.createDataCharge.value createDataCharge
         * @returns String
         */
        initHtmlSpotBlock: function(registCharge, createDataCharge) {
            var data = dataTrans || null;
            return'<h4>'+(data.spot.head_main_spot||null)+'</h4>'
                        +'<div class="content-block table-block">'
                    +'<table class="table table-blue table-ship">'
                        +'<thead>'
                            +'<tr>'
                                +'<th>No</th>'
                                +'<th>'+(data.spot.head_type_1||null)+'</th>'
                                +'<th>'+(data.spot.head_type_2||null)+'</th>'
                            +'</tr>'
                        +'</thead>'
                        +'<tbody>'
                            +'<tr>'
                                +'<td>1</td>'
                                +'<td>'+(data.spot.spot_regist||null)+'</td>'
                                +'<td class=""><input class="form-control" placeholder="'+(data.spot.spot_regist||null)+'" name="chargeRegister" type="text" value="'+registCharge+'"></td>'
                            +'</tr>'
                            +'<tr>'
                                +'<td>2</td>'
                                +'<td>'+(data.spot.spot_create||null)+'</td>'
                                +'<td class=""><input class="form-control" placeholder="'+(data.spot.spot_create||null)+'" name="chargeCreate" type="text" value="'+createDataCharge+'"></td>'
                            +'</tr>'
                        +'</tbody>'
                    +'</table>'
                +'</div>';
        },

        /**
         * Handle search service modal
         * 
         * @returns void
         */
        search: function () {

            var idServiceSearch = $(searchService.models.inputIdServiceSearch).val();
            var nameServiceSearch = $(searchService.models.inputNameServiceSearch).val();
            var currencyId = $(searchService.models.currencyId).val();
            var serviceIdOld = $(searchService.models.serviceIdOld).val()||null;
            var shipId = ($(searchService.models.shipIdHidden).length > 0)
                            ?$(searchService.models.shipIdHidden).val()
                            :$(searchService.models.shipId).val();
            var url = location.protocol + "//" + location.host + '/search/service/' + 'search';

            if (currencyId != null && (idServiceSearch.length > 0 || nameServiceSearch.length > 0)) {

                // Handle ajax send data to server
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "shipId": shipId,
                        "currencyId": currencyId,
                        "idServiceSearch": idServiceSearch,
                        "nameServiceSearch": nameServiceSearch,
                        "serviceId": serviceIdOld,
                        "_token": App.getToken()
                    },
                    success: function (data) {
                        searchService.events.updateContentByData(data);
                    },
                    // Not do anything when error
                    error: function (error) {
                        return false;
                    }
                });

            } else if (currencyId != null) {
                searchService.events.load();
            }
        },

        /**
         * Load data into DOM element on modal after handle ajax request
         * from modal search service
         * 
         * @param object data
         * @returns void
         */
        updateContentByData: function (data) {

            $(searchService.models.contentSearch).empty();

            /**
             * When exists result from response:
             * Add class table-fixed into table result get height of table
             * Render html and append to body of table
             */
            if (data.length > 0) {

                var content = null;
                var countForEach = 0;
                var serviceHidden = $(searchService.models.serviceIdHidden).val();
                data.forEach(function (item) {

                    searchService.events.addClassTableFixed();

                    var string = '';

                    string = '<tr>'
                            + '<td style="width: 20%">' + item['id'] + '</td>'
                            + '<td style="width: 70%">' + item['name_jp'] + '</td>'
                            + '<td style="width: 10%">'
                            + '<div class="custom-radio">'
                            + '<input data-value="' + item['id'] + '" value="' + item['id'] + '" class="hidden" id="search-service' + item['id'] + '" name="search-service-id" type="radio" ';

                     /**
                     * If is edit screen and exists default ship id:
                     * The first, auto check id default. After search, if id eval previous id selected, auto select it.
                     */
                    if (typeof serviceHidden !== "undefined" && serviceHidden != '') {
                        if (serviceHidden == item['id']) {
                            string = string + 'checked="checked">';
                        } else {
                            string = string + '>';
                        }
                    /**
                     * If is create screen and not exists default ship id:
                     * Auto check on first item
                     */
                    } else {
                        if (countForEach == 0) {
                            string = string + 'checked="checked">';
                        } else {
                            string = string + '>';
                        }
                    }

                    string = string + '<label for="search-service' + item['id'] + '"></label>'
                            + '</div>'
                            + '</td>'
                            + '</tr>';

                    string = string + '<input name="chargeRegister' + item['id'] + '" type="hidden" value="' + item['charge_register'] + '">\n\
                                       <input name="chargeCreate' + item['id'] + '" type="hidden" value="' + item['charge_create_data'] + '">\n\
                                       <input name="nameJP' + item['id'] + '" type="hidden" value="' + item['name_jp'] + '">';

                    content = content + string;

                    // Decrease count foreach
                    countForEach++;
                });

                $(searchService.models.contentSearch).html(content);

            } else {
                /**
                 * When no result from response ajax:
                 * Remove class table fix to clean height default px of body table
                 * Clean previous content html of body table
                 */
                searchService.events.removeClassTableFixed();
                $(searchService.models.contentSearch).html('');
            }
        },

        /**
         * Load data into DOM element after click button OK on search service modal
         * 
         * @returns void
         */
        chosseValue: function () {
            if ($("input[name=search-service-id]:checked").length > 0) {
                var idChosse = $('input[name=search-service-id]:checked').val();
                var id = $("input[name=search-service-id]:checked").data().value;
                var chargeRegister = $('input[name=chargeRegister' + id + ']').val();
                var chargeCreate = $('input[name=chargeCreate' + id + ']').val();
                var nameJP = $('input[name=nameJP' + id + ']').val();

                chargeRegister = Events.separateCommaValue(chargeRegister);
                chargeCreate = Events.separateCommaValue(chargeCreate);

                $(searchService.models.chargeRegister).val(chargeRegister);
                $(searchService.models.chargeCreate).val(chargeCreate);
                $(searchService.models.inputIdService).val(nameJP);
                $(searchService.models.serviceIdHidden).val(idChosse);

                if (searchService.models.isUpdate) {
                    if (idChosse != searchService.models.oldService) {
                        searchService.models.isChangeService = true;
                        $(searchService.models.elSpotBlock).empty();
                        $(searchService.models.elSpotBlock).html(searchService.events.initHtmlSpotBlock(chargeRegister, chargeCreate));
                    } else {
                        searchService.models.isChangeService = false;
                        // When user reject approve create contract, autoload 
                        // spot register and create for user in contract edit screen
                        $(searchService.models.elSpotBlock).html(searchService.models.initElSpotBlock);
                        if (typeof searchShip !== "undefined" && searchShip.models.isChangeShip) {
                            $(searchService.models.elSpotBlock).html(searchService.events.initHtmlSpotBlock(chargeRegister, chargeCreate));
                        }
                    }
                }
            }
        },

        removeClassTableFixed: function () {
            $("#table-content-search-sv").removeClass("table-fixed");
        },

        addClassTableFixed: function () {
        }
    };
};

$(document).ready(function () {
    searchService.init();
});
