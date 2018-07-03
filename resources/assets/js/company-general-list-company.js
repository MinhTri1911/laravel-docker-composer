/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @description click show popup detail company
 */
$('.open-popup-detail-company').on('click', function () {
    let url = $(this).attr('data-url') + '?detail-type=0';
    showPopup(url);
})

/**
 * @description click show popup detail system
 */
$('.open-popup-detail-system').on('click', function () {
    let url = $(this).attr('data-url') + '?detail-type=1';
    showPopup(url);
})

/**
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
 * @name function restart Perfect scroll
 */
function restartPs() {
    const table = document.querySelector('.block-table');
    const psWidth = new PerfectScrollbar(table, function () {
        table.style.width = '100%'
    });

    const content = document.querySelector('.table-content');
    const psHeight = new PerfectScrollbar(content, function () {
        content.style.height = '300px'
    });

    // remove class when init
    $('.block-table').removeClass('ps--active-y');
}

/**
 * @description replace url paginate when sort data
 */
function replaceUrlPagination () {
    let obj = JSON.parse($('#sort-value').val());
    // set query string
    for (var key in obj) {
        if (obj[key] == 1) {
            query = {
                'field' : key,
                'sortBy' : obj[key]
            }
            break;
        } else {
            query = {
                'field': '',
                'sortBy': 0
            }
        }
    }

    $('.pagination li').find('a').each(function (index) {
        // replace url for paginate when sorting
        if ($(this).attr('data-url')) {
            let url = $(this).attr('data-url') + '&field=' + query.field + '&sortBy=' + query.sortBy;
            $(this).attr('data-url', url);
        }
    });
}

/**
 * @description custom paginate list company
 */
$(document).on('click', '.pagination li a', function (event) {
    let url = $('#' + $(this).attr('id')).attr('data-url');
    // save state checkbox
    saveCheckedWhenLoad();
    $.get(url, function (res) {
        if (res.code == 200) {
            if (res.typeRender === 'filter') {
                $('.table-content').empty()
                $('.table-content').append(res.table)
            } else {
                $('.block-table').empty()
                $('.block-table').append(res.table)
            }

            $('#area-paginate').empty()
            $('#area-paginate').append(res.paginate)
            restartPs();
            // reset url for sort action
            $('#sort-value').attr('data-url', url);
            replaceUrlPagination ();
            // make checked checkbox
            checkedState();
        }
    })
})

/**
 * @description click filter company
 * @description click event after ajax
 */
$(document).on('click', '#btn-filter', function (event) {
    let keywords = $(":input").serializeArray();
    let url = $(this).attr('data-url') + '?page=1';
    keywords.forEach(function (element, index) {
        if (element.name !== '_token')
            url += '&' + element.name + '=' + element.value;
    });

    let searchValue = JSON.parse($('#value-after-search').val());
    let query = {
        'group' : searchValue.group,
        'load' : searchValue.load,
    }

    $.get(url, query,function (res) {
        if (res.code == 200) {
            $('.table-content').empty();
            $('.table-content').append(res.table);
            $('#area-paginate').empty();
            $('#area-paginate').append(res.paginate);
            restartPs();
            // reset url for sort action
            $('#sort-value').attr('data-url', url);
        }
    });
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

    // set value select after click search
    $('#value-after-search').val(JSON.stringify(query));

    $.get(url, query, function (res) {
        if (res.code == 200) {
            $('.block-table').empty();
            $('.block-table').append(res.table);
            $('#area-paginate').empty();
            $('#area-paginate').append(res.paginate);
            restartPs();
            // reset url for sort action
            $('#sort-value').attr('data-url', url);
            // make checked checkbox
            checkedState();
        }
    });
});

/**
 * @description action click sort data
 */
$(document).on('click', '.th-line-one i', function (event) {
    let dataSort = $(this).attr('data-sort');
    let obj = JSON.parse($('#sort-value').val());
    let url = $('#sort-value').attr('data-url');
    let demo = JSON.parse($('#value-after-search').val());
    let query = {
        'field' : dataSort,
        'group' : demo.group,
        'load' : demo.load,
    }

    // set status for sort
    for (var key in obj) {
        if (key === dataSort) {
            obj[key] = (obj[key] == 1) ? 0 : 1;
            query.sortBy = obj[key];
        }
    }

    $('#sort-value').val(JSON.stringify(obj))

    $.get(url, query, function (res) {
        if (res.code == 200) {
            if (res.typeRender === 'filter') {
                $('.table-content').empty()
                $('.table-content').append(res.table)
            } else {
                $('.block-table').empty()
                $('.block-table').append(res.table)
            }

            $('#area-paginate').empty()
            $('#area-paginate').append(res.paginate)
            restartPs();
            // reset url for sort action
            $('#sort-value').attr('data-url', url);
            replaceUrlPagination ();
            // make checked checkbox
            checkedState();
        }
    })
})

/**
 * @description action click check all
 */
$('#cb-all').change(function() {
    if(this.checked) {
        $("input[name='cb-get-id[]']").each(function () {
            this.checked = true;
        })
    } else {
        $("input[name='cb-get-id[]']").each(function () {
            this.checked = false;
        })
    }

    // saveCheckedWhenLoad()
});

// $(document).on('click', ".table-result tbody tr td input:checkbox[name='cb-get-id[]']:checked", function (event) {
//     console.log($(this).val())
// })

function saveCheckedWhenLoad () {
    let demo = $("input:checkbox[name='cb-get-id[]']:checked").serializeArray();
    let storage = JSON.parse(window.localStorage.getItem('tracker'));

    if (storage === null) storage = {}

    storage[$('#current-page').attr('data-page')] = [];
    demo.forEach(function (element, index) {
        storage[$('#current-page').attr('data-page')][element.value] = element.value
    });

    window.localStorage.setItem('tracker', JSON.stringify(storage));
}

function checkedState () {
    let page = $('#current-page').attr('data-page');
    let storage = JSON.parse(window.localStorage.getItem('tracker'));

    if (storage === null) return true;

    for (var index in storage[page]) {
        $('#cb-company-' + storage[page][index]).prop('checked', true);
    }
}
