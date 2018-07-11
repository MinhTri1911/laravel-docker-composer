var searchShip = new function () {

    this.models = {
        contentSearch: "#content-data-search-ship",
        companyId: "input[name=companyId]",
        btnOk: "#btn-ok",
        btnSearch: "#btn-search-ship",
        inputIdShip: "input[name=idShip]",
        inputIdShipSearch: "input[name=idShipSearch]",
        inputNameShipSearch: "input[name=nameShipSearch]",
        showModalShip: ".show-modal-ship"
    };

    this.init = function () {

        searchShip.events.load();

        $(document).on('click', searchShip.models.btnOk, function (e) {
            searchShip.events.chosseValue();
        });

        $(document).on('click', searchShip.models.btnSearch, function (e) {
            searchShip.events.search();
        });

        $(document).on('click', searchShip.models.showModalShip, function (e) {
            searchShip.events.load();
        });

    };

    this.events = {

        load: function () {

            $(searchShip.models.contentSearch).empty();

            var url = location.protocol + "//" + location.host + '/search/ship/' + 'init';

            var companyId = $(searchShip.models.companyId).val();

            // Handle ajax send data to server
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "companyId": companyId,
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

            if (data.length > 0) {

                var content = null;
                var countForEach = 0;

                data.forEach(function (item) {

                    searchShip.events.addClassTableFixed();

                    var string = '';

                    string = '<tr>'
                            + '<td style="width: 20%">' + item['id'] + '</td>'
                            + '<td style="width: 70%">' + item['name'] + '</td>'
                            + '<td style="width: 10%">'
                            + '<div class="custom-radio">'
                            + '<input value="' + item['id'] + '" class="hidden" id="search-ship' + item['id'] + '" name="search-ship-id" type="radio" ';

                    if (countForEach == 0) {
                        string = string + 'checked="checked">';
                    } else {
                        string = string + '>';
                    }

                    string = string + '<label for="search-ship' + item['id'] + '"></label>'
                            + '</div>'
                            + '</td>'
                            + '</tr>';

                    content = content + string;

                    countForEach++;
                });

                $(searchShip.models.contentSearch).html(content);

            } else {
                searchShip.events.removeClassTableFixed();
                $(searchShip.models.contentSearch).html('');
            }
        },

        chosseValue: function () {

            var idChosse = $('input[name=search-ship-id]:checked').val();

            $(searchShip.models.inputIdShip).val(idChosse);
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


