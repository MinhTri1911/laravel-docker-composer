$(document).ready(function () {

    //Show search protector modal
    $(document).on('click', '#select-protector-btn', function () {
        $('#modal-search-protector').modal('show');
    });
    
    //Select only one checkbox at a time of select-protector list
    $(document).on('change', '.select-protector', function () {
        $('.select-protector').not(this).prop('checked', false); 
    });
    
    var objParam = {};

    //Press search protector
    $(document).on('click', '#search-protector-btn-modal', function (e) {
        //Clear result of prev search
        $('#result-search-protector').empty();
        
        var elements = document.getElementById("form-search-protector").elements;
        for (var i = 0; i < elements.length; i++) {
            var item = elements.item(i);
            objParam[item.name] = item.value;
        }
        searchProtector(1);
        e.preventDefault();
    });
    
    //Click pagination link in protector popup
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        searchProtector($(this).attr('href').split('page=')[1]);
    });
    
    
    //Choose protector from popup
    $(document).on('click', '#choose-protector-btn-modal', function () {
        $('input[name="protector_id_select"]').each(function() {
            if($(this).is(":checked")) {
                listProtector = $(this).val();
                var content = "<image class='delete-protector' src='/images/delete.png'/>"
                               + $(this).data('name-protector')
                               + "<input type='hidden' name='protector_id' value='" + $(this).val() + "'/>"
                               + "<input type='hidden' name='protector_name' value='" + $(this).data('name-protector') + "'/>";
                $('#select_protector').empty();
                $('#select_protector').append(content);
            }
        });
    });

    //Choose protector from popup
    $(document).on('click', '.delete-protector', function () {
        $('#select_protector').html('');
    });

    /**
     * Handle show search result
     * @param {int} numRecords
     * @returns
     */
    function handleResult(numRecords) {
        if (numRecords > 0) {
            $("#result-search-protector").show();
            $("#msgNoRecord").hide();
        }
        //No record, show only msg 0 record
        else {
            $("#result-search-protector").hide();
            $("#msgNoRecord").show();
        }
    }

    /**
     * Search protector function
     * @param {int} page for pagindator
     */
    function searchProtector(page) {

        $('#result-search-protector').empty();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        });

        $.ajax({
            type: "POST",
            url: '/users/general/individual/search/protector',
            dataType: 'json',
            data: {
                "page": page,
                "param": objParam
            },
            success: function (data) {
                handleResult(data.totalRecords);
                $('#result-search-protector').append(data.data);
            },
            error: function (e) {
                handleError(e);
            }
        });
    }
});
