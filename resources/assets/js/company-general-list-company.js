/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @description click show popup detail company
 */
$('.open-popup-detail-company').on('click', function () {
    let url = $(this).attr('data-url') + '?detail-type=0';
    showPopup(url);
})

/**
 *
 * @description click show popup detail system
 */
$('.open-popup-detail-system').on('click', function () {
    let url = $(this).attr('data-url') + '?detail-type=1';
    showPopup(url);
})

/**
 *
 * @name function call ajax show popup detail company/system
 * @param {type} url
 * @returns {undefined}
 */
function showPopup(url) {
    $.get(url, function (res) {
        $('#modal-protector').empty();
        $('#modal-protector').append(res.view);
        $('#modal-protector').modal('show');
    });
}

/**
 * @description custom paginate list company
 */
$(document).on('click', '.pagination', function (event) {
    let url = $('#' + event.target.getAttribute('id')).attr('data-url')
    // let status = $('#' + event.target.getAttribute('id')).attr('data-status')
    console.log(url)
    // if (!status) {
        $.get(url, function (res) {
            if (res.code == 200) {

                $('.table-content').empty()
                $('.table-content').append(res.table)
                $('#area-paginate').empty()
                $('#area-paginate').append(res.paginate)
            }
        })
    // }

})

/**
 * @description click filter company
 */
$('#btn-filter').on('click', function () {
    let keywords = $(":input").serializeArray();
    let url = $(this).attr('data-url') + '?page=1';
    keywords.forEach(function(element, index) {
        url += '&' + element.name + '=' + element.value
    })

    $.get(url, function (res) {
        if (res.code == 200) {
            $('.table-content').empty()
            $('.table-content').append(res.table)
            $('#area-paginate').empty()
            $('#area-paginate').append(res.paginate)
        }
    })
});

/**
 * @description click search company
 */
$('#btn-search-company').on('click', function () {
    let url = $(this).attr('data-url');
    let query = {
        'group' : $('#group-type').val(),
        'load' : $('#load-result').val(),
    }

    $.get(url, query, function (res) {
        console.log(res)
        if (res.code == 200) {
            $('.block-table').empty()
            $('.block-table').append(res.table)
            $('#area-paginate').empty()
            $('#area-paginate').append(res.paginate)
        }
    })
});
