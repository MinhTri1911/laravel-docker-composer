var spotCreate = new function () {

    this.models = {
        spotId: "#spot-id",
        currencyId: "input[name=currencyId]",
        amountCharge : "input[name=amountCharge]"
    };

    this.init = function () {

        $(document).on('change', spotCreate.models.spotId, function (e) {
            var id = $(this).val();
            spotCreate.events.setValueAmountCharge(id);
        });
    };

    this.events = {

        setValueAmountCharge: function (id) {
            
            var url = location.protocol + "//" + location.host + '/spot/search/amount';
            
            var currencyId = $(spotCreate.models.currencyId).val();
            
            // Handle ajax send data to server
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "spotId": id,
                    "currencyId" : currencyId
                },
                success: function (data) {
                    console.log(data);
                    
                    $(spotCreate.models.amountCharge).val(data);
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