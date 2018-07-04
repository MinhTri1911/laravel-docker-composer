/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
function replaceUrlPagination() {
    let obj = JSON.parse($('#sort-value').val());
    // set query string
    for (var key in obj) {
        if (obj[key] == 1) {
            query = {
                'field': key,
                'sortBy': obj[key]
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
 * @description save id to localstorage when checkbox checked
 */
function saveCheckedWhenLoad() {
    let checkboxs = $("input:checkbox[name='cb-get-id[]']:checked").serializeArray();
    let typeGroup = JSON.parse($('#value-after-search').val());
    let storage = null;
    let storageService = null;

    if (typeGroup.group == 0) {
        storage = JSON.parse(window.localStorage.getItem('tracker-group-company'));
    } else {
        storage = JSON.parse(window.localStorage.getItem('tracker-group-service'));
        storageService = JSON.parse(window.localStorage.getItem('tracker-value-service'));

        if (storageService === null) storageService = {}

        storageService[$('#current-page').attr('data-page')] = [];
    }

    if (storage === null) storage = {}

    // save checkbox id to object
    storage[$('#current-page').attr('data-page')] = [];

    checkboxs.forEach(function (element, index) {
        storage[$('#current-page').attr('data-page')][element.value] = element.value

        if (storageService != null) {
            storageService[$('#current-page').attr('data-page')][element.value] = $('#cb-get-id-' + element.value).attr('data-company-ids');
        }
    });

    // save id checkbox to localstorage with group = 0 is company group = 1 is service
    typeGroup.group == 0
        ? window.localStorage.setItem('tracker-group-company', JSON.stringify(storage))
        : window.localStorage.setItem('tracker-group-service', JSON.stringify(storage));

    if (storageService != null) window.localStorage.setItem('tracker-value-service', JSON.stringify(storageService));
}

/**
 * @description make checkbox checked when load page
 */
function checkedStateOfCheckbox() {
    let typeGroup = JSON.parse($('#value-after-search').val());
    // get current page
    let page = parseInt($('#current-page').attr('data-page'));
    let storage = null;
    let countCheckboxInCurrentPage = 0;

    if (typeGroup.group == 0) {
        storage = JSON.parse(window.localStorage.getItem('tracker-group-company'));
    } else {
        storage = JSON.parse(window.localStorage.getItem('tracker-group-service'));
    }

    if (storage == null) return true;

    // make checkbox checked
    for (var index in storage[page]) {
        if (storage[page][index] != null) {
            $('#cb-get-id-' + storage[page][index]).prop('checked', true);
            countCheckboxInCurrentPage++;
        }
    }

    if (typeGroup.group == 0 && page != 1 && storage[page - 1] != undefined) {
        for (var indexPrev in storage[page - 1]) {
            if (storage[page - 1][indexPrev] != null) {
                $('#cb-get-id-' + storage[page - 1][indexPrev]).prop('checked', true);
            }
        }
    }

    if (typeGroup.group == 0 && storage[page + 1] != undefined) {
        for (var indexNext in storage[page + 1]) {
            if (storage[page + 1][indexNext] != null) {
                $('#cb-get-id-' + storage[page + 1][indexNext]).prop('checked', true);
            }
        }
    }

    let status = 0;
    $("input[name='cb-get-id[]']").each(function () {
        status++;
    });

    if (status == countCheckboxInCurrentPage && countCheckboxInCurrentPage > 0) {
        $('#cb-all').prop('checked', true);
    }
}

/**
 * @description remove id in localstorage when change action filter/ search/ sort
 */
function removeStateChecked () {
    if (window.localStorage.getItem('tracker-group-company') !== null) {
        window.localStorage.removeItem('tracker-group-company');
    }

    if (window.localStorage.getItem('tracker-group-service')  !== null) {
        window.localStorage.removeItem('tracker-group-service');
    }

    if (window.localStorage.getItem('tracker-value-service') !== null) {
        window.localStorage.removeItem('tracker-value-service');
    }

    $('#cb-all').prop('checked', false);
    $("input:checkbox[name='cb-get-id[]']:checked").prop('checked', false);
}

/**
 * @description click show popup detail company
 */
$(document).on('click', '.open-popup-detail-company', function () {
    let url = $(this).attr('data-url') + '&detail-type=0';
    showPopup(url);
})

/**
 * @description click show popup detail system
 */
$(document).on('click', '.open-popup-detail-service', function () {
    console.log(123);
    let url = $(this).attr('data-url') + '&detail-type=1';
    showPopup(url);
})

/**
 * @description custom paginate list company
 */
$(document).on('click', '.pagination li a', function (event) {
    let url = $('#' + $(this).attr('id')).attr('data-url')
    // save checkbox is checked
    saveCheckedWhenLoad();
    $('#cb-all').prop('checked', false);

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
            replaceUrlPagination();
            // make checkbox checked
            checkedStateOfCheckbox();
        }
    })
})

/**
 * @description click filter company
 * @description click event after ajax
 */
$(document).on('click', '#btn-filter', function (event) {
    removeStateChecked();
    let keywords = $(":input").serializeArray();
    let url = $(this).attr('data-url') + '?page=1';
    keywords.forEach(function (element, index) {
        if (element.name !== '_token')
            url += '&' + element.name + '=' + element.value;
    });

    let searchValue = JSON.parse($('#value-after-search').val());
    let query = {
        'group': searchValue.group,
        'load': searchValue.load,
    }

    $.get(url, query, function (res) {
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
    removeStateChecked();
    let url = $(this).attr('data-url');
    let query = {
        'group': $('#group-type').val(),
        'load': $('#load-result').val(),
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

            // checked
            checkedStateOfCheckbox();
        }
    });
});

/**
 * @description click sort data
 */
$(document).on('click', '.th-line-one i', function (event) {
    removeStateChecked();
    let dataSort = $(this).attr('data-sort');
    let obj = JSON.parse($('#sort-value').val());
    let url = $('#sort-value').attr('data-url');
    let searchValue = JSON.parse($('#value-after-search').val());
    let query = {
        'field': dataSort,
        'group': searchValue.group,
        'load': searchValue.load,
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
            replaceUrlPagination();
        }
    })
})

/**
 * @description action click check all
 */
$(document).on('change', '#cb-all', function() {
    if(this.checked) {
        $("input[name='cb-get-id[]']").each(function () {
            this.checked = true;
        })
    } else {
        $("input[name='cb-get-id[]']").each(function () {
           this.checked = false;
        })
    }
});

/**
 * @description action click checkbox
 * @description uncheck checkbox select all if uncheck checkbox get id
 */
$(document).on('change', '.checkbox-table', function (event) {
    if (!$('#' + event.target.getAttribute('id')).prop('checked')) {
        $('#cb-all').prop('checked', false);
    }
});

/**
 * @description click button redirect to histori billing
 */
$('#history-billing').on('click', function () {
    saveCheckedWhenLoad()
    let typeGroup = JSON.parse($('#value-after-search').val());
    let storage = null;
    let url =$(this).attr('data-url');

    if (typeGroup.group == 0) {
        storage = JSON.parse(window.localStorage.getItem('tracker-group-company'));
    } else {
        storage = JSON.parse(window.localStorage.getItem('tracker-value-service'));
    }

    if (storage == null) {
        window.location.href = url;
    } else {
        url += '?id=';
        for (var pageId in storage) {
            storage[pageId].forEach(function (element, index) {
                if (element != null) {
                    url += element + ',';
                }
            });
        }

        url = url.split(',').filter(function (item, i, allItems){
            return i == allItems.indexOf(item);
        }).join(',').slice(0, -1);

        window.location.href = url;
    }
})

/**
 * @description init page
 */
$(document).ready(function () {
    removeStateChecked ();
    checkedStateOfCheckbox();
})
