var searchService = new function () {

    this.models = {
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
        serviceIdHidden : "input[name=serviceIdHidden]"
    };

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
        
    };

    this.events = {

        load: function () {

            $(searchService.models.contentSearch).empty();

            var url = location.protocol + "//" + location.host + '/search/service/' + 'init';

            var shipId = $(searchService.models.shipId).val();
            var currencyId = $(searchService.models.currencyId).val();

            if (currencyId != null) {

                // Handle ajax send data to server
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "shipId": shipId,
                        "currencyId": currencyId,
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

        search: function () {

            var idServiceSearch = $(searchService.models.inputIdServiceSearch).val();
            var nameServiceSearch = $(searchService.models.inputNameServiceSearch).val();
            var shipId = $(searchService.models.shipId).val();
            var currencyId = $(searchService.models.currencyId).val();

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

        updateContentByData: function (data) {

            $(searchService.models.contentSearch).empty();

            if (data.length > 0) {

                var content = null;
                var countForEach = 0;

                data.forEach(function (item) {

                    searchService.events.addClassTableFixed();

                    var string = '';

                    string = '<tr>'
                            + '<td style="width: 20%">' + item['id'] + '</td>'
                            + '<td style="width: 70%">' + item['name_jp'] + '</td>'
                            + '<td style="width: 10%">'
                            + '<div class="custom-radio">'
                            + '<input data-value="' + item['id'] + '" value="' + item['id'] + '" class="hidden" id="search-service' + item['id'] + '" name="search-service-id" type="radio" ';

                    if (countForEach == 0) {
                        string = string + 'checked="checked">';
                    } else {
                        string = string + '>';
                    }

                    string = string + '<label for="search-service' + item['id'] + '"></label>'
                            + '</div>'
                            + '</td>'
                            + '</tr>';

                    string = string + '<input name="chargeRegister' + item['id'] + '" type="hidden" value="' + item['charge_register'] + '">\n\
                                       <input name="chargeCreate' + item['id'] + '" type="hidden" value="' + item['charge_create_data'] + '">\n\
                                       <input name="nameJP' + item['id'] + '" type="hidden" value="' + item['name_jp'] + '">';


                    content = content + string;

                    countForEach++;
                });

                $(searchService.models.contentSearch).html(content);

            } else {
                searchService.events.removeClassTableFixed();
                $(searchService.models.contentSearch).html('');
            }
        },

        chosseValue: function () {
            var idChosse = $('input[name=search-service-id]:checked').val();
            var id = $("input[name=search-service-id]:checked").data().value;
            var chargeRegister = $('input[name=chargeRegister' + id + ']').val();
            var chargeCreate = $('input[name=chargeCreate' + id + ']').val();
            var nameJP = $('input[name=nameJP' + id + ']').val();

            $(searchService.models.chargeRegister).val(chargeRegister);
            $(searchService.models.chargeCreate).val(chargeCreate);
            $(searchService.models.inputIdService).val(nameJP);
            $(searchService.models.serviceIdHidden).val(idChosse);
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


