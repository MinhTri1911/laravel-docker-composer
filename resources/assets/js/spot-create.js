var spotCreate = new function () {

    this.models = {
        spotId: "#spot-id",
        currencyId: "input[name=currencyId]",
        amountCharge: "input[name=amountCharge]"
    };

    this.init = function () {

        $(document).on('change', spotCreate.models.spotId, function (e) {
            var id = $(this).val();
            spotCreate.events.setValueAmountCharge(id);
        });

        $(document).on('keyup', "input[name='amountCharge']", function (e) {
            Events.separateComma($(this));
        });
    };

    this.events = {

        setValueAmountCharge: function (id) {

            var url = location.protocol + "//" + location.host + '/ship/spot/search/amount';

            var currencyId = $(spotCreate.models.currencyId).val();

            // Handle ajax send data to server
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "spotId": id,
                    "currencyId": currencyId
                },
                success: function (data) {
                    $(spotCreate.models.amountCharge).val(data + '.00');
                },
                // Not do anything when error
                error: function (error) {
                    return false;
                }
            });
        }
    };

};

$(document).ready(function () {
    spotCreate.init();
});