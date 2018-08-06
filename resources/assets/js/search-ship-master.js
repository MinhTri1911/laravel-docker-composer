var searchShip = new function () {

    this.models = {
        // Check current screen is edit contract
        isUpdate: false,
        // Check if user select other ship
        isChangeShip: false,
        // Initial current ship id
        oldShip: null,
        // Initial current service id
        oldService: null,
        // DOM Element content search service
        contentSearch: "#content-data-search-ship",
        companyId: "input[name=companyId]",
        btnOk: "#btn-ok-ship",
        btnSearch: "#btn-search-ship",
        inputIdShip: "input[name=idShip]",
        inputIdShipSearch: "input[name=idShipSearch]",
        inputNameShipSearch: "input[name=nameShipSearch]",
        showModalShip: ".show-modal-ship",
        serviceIdHidden : "input[name=serviceIdHidden]",
        shipIdHidden : "input[name=shipIdHidden]",
        currencyId : "input[name=currencyId]",
        // DOM Element of spot section
        elSpotBlock: ".spot-block"
    };

    this.init = function () {

//        searchShip.events.load();

        $(document).on('click', searchShip.models.btnOk, function (e) {
            searchShip.events.chosseValue();
        });

        $(document).on('click', searchShip.models.btnSearch, function (e) {
            searchShip.events.search();
        });

        $(document).on('click', searchShip.models.showModalShip, function (e) {
            searchShip.events.load();
        });
        
        var shipHidden = $(searchShip.models.shipIdHidden).val();
        var serviceHidden = $(searchShip.models.serviceIdHidden).val();
        
        if (typeof shipHidden != "undefined" && shipHidden !== '' && !isNaN(shipHidden)
                && typeof serviceHidden != "undefined" && serviceHidden !== '' && !isNaN(serviceHidden) ) {
            searchShip.models.isUpdate = true;
            searchShip.models.oldShip = shipHidden;
            searchShip.models.oldService = serviceHidden;
        }
    };

    this.events = {

        load: function () {

            $(searchShip.models.contentSearch).empty();

            var url = location.protocol + "//" + location.host + '/search/ship/' + 'init';

            var companyId = $(searchShip.models.companyId).val();
            var serviceIdHidden = $(searchShip.models.serviceIdHidden).val()||null;
            var currencyId = $(searchShip.models.currencyId).val()||null;
            // Handle ajax send data to server
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "companyId": companyId,
                    "serviceId": serviceIdHidden,
                    "currencyId": currencyId,
                    "_token": App.getToken()
                },
                success: function (data) {
                    searchShip.events.updateContentByData(data);
                },
                // Not do anything when error
                error: function (error) {
                    return false;
                }
            });

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
        
        search: function () {

            var companyId = $(searchShip.models.companyId).val();
            var idShipSearch = $(searchShip.models.inputIdShipSearch).val();
            var nameShipSearch = $(searchShip.models.inputNameShipSearch).val();


            var url = location.protocol + "//" + location.host + '/search/ship/' + 'search';

            if (idShipSearch.length > 0 || nameShipSearch.length > 0) {

                // Handle ajax send data to server
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "companyId": companyId,
                        "idShipSearch": idShipSearch,
                        "nameShipSearch": nameShipSearch,
                        "_token": App.getToken()
                    },
                    success: function (data) {
                        searchShip.events.updateContentByData(data);
                    },
                    // Not do anything when error
                    error: function (error) {
                        return false;
                    }
                });

            } else {
                searchShip.events.load();
            }
        },

        updateContentByData: function (data) {

            $(searchShip.models.contentSearch).empty();

            if (data.ships.length > 0) {

                var content = null;
                var countForEach = 0;
                var shipHidden = $(searchShip.models.shipIdHidden).val();
                
                data.ships.forEach(function (item) {
                    searchShip.events.addClassTableFixed();

                    var string = '';

                    string = '<tr>'
                            + '<td style="width: 20%">' + item['id'] + '</td>'
                            + '<td style="width: 70%">' + item['name'] + '</td>'
                            + '<td style="width: 10%">'
                            + '<div class="custom-radio">'
                            + '<input value="' + item['id'] + '" class="hidden" id="search-ship' + item['id'] + '" name="search-ship-id" type="radio" ';
                    /**
                     * If is edit screen and exists default ship id:
                     * The first, auto check id default. After search, if id eval previous id selected, auto select it.
                     */
                    if (typeof shipHidden !== "undefined" && shipHidden != '') {
                        if (shipHidden == item['id']) {
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

                    string = string + '<label for="search-ship' + item['id'] + '"></label>'
                            + '</div>'
                            + '</td>'
                            + '</tr>';

                    string = string + '<input name="name' + item['id'] + '" type="hidden" value="' + item['name'] + '">';

                    content = content + string;

                    countForEach++;
                });
                
                if (typeof data.services != "undefined" && data.services.length > 0) {
                    data.services.forEach(function(el) {
                       var string = '<input name="chargeRegister' + el['service_id'] + '" type="hidden" value="' + el['charge_register'] + '">\n\
                           <input name="chargeCreate' + el['service_id'] + '" type="hidden" value="' + el['charge_create_data'] + '">';
                        content += string;
                    });
                }

                $(searchShip.models.contentSearch).html(content);

            } else {
                searchShip.events.removeClassTableFixed();
                $(searchShip.models.contentSearch).html('');
            }
        },

        chosseValue: function () {
            if ($("input[name=search-ship-id]:checked").length > 0) {
                var idChosse = $('input[name=search-ship-id]:checked').val();
                var serviceId = $(searchShip.models.serviceIdHidden).val();
                var chargeRegister = $('input[name=chargeRegister' + serviceId + ']').val();
                var chargeCreate = $('input[name=chargeCreate' + serviceId + ']').val();
                var name = $('input[name=name' + idChosse + ']').val();
                $(searchShip.models.inputIdShip).val(name);
                $(searchShip.models.shipIdHidden).val(idChosse);
                
                chargeRegister = Events.separateCommaValue(chargeRegister);
                chargeCreate = Events.separateCommaValue(chargeCreate);
                
                // If current screen is update:
                // If user select other ship, add spot for ship selected
                // If user change service not change ship, add spot base on service selected, else don't change both service 
                // and ship then empty spot and don't insert spot.
                if (searchShip.models.isUpdate) {
                    if (idChosse != searchShip.models.oldShip) {
                        searchShip.models.isChangeShip = true;
                        $(searchShip.models.elSpotBlock).empty();
                        $(searchShip.models.elSpotBlock).html(searchShip.events.initHtmlSpotBlock(chargeRegister, chargeCreate));
                    } else {
                        searchShip.models.isChangeShip = false;
                        $(searchShip.models.elSpotBlock).empty();
                        // When restore contract, user may be change ship and service
                        // If change service, keep spot cost responsibility to service selected
                        if (typeof searchService != "undefined" && searchService.models.isChangeService) {
                            $(searchShip.models.elSpotBlock).html(searchShip.events.initHtmlSpotBlock(chargeRegister, chargeCreate));
                        }
                    }
                }
            }
        },
        
        removeClassTableFixed: function () {
            $("#table-content-search-ship").removeClass("table-fixed");
        },

        addClassTableFixed: function () {

        }
    };

};

$(document).ready(function () {
    searchShip.init();
});


