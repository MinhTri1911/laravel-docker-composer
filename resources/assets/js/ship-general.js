/**
 * Define ship constant
 */
const $tableContent = $('.table-content');
const $blockTable = $('.block-table');
const $areaPaginate = $('#area-paginate');
const $sortValue = $('#sort-value');
const $totalResult = $('#total-result');
const HTTP_SUCCESS_CODE = 200;

/**
 * Pagination function,
 * Handle paginate and send request to server
 *
 * @return void
 */
$(document).on('click', '.pagination li a', function (event) {
    // Get paginate URL redirect for ajax send
    let url = $('#' + $(this).attr('id')).attr('data-url');

    // Send ajax to server
    $.get(url, function (res) {
        if (res.code === HTTP_SUCCESS_CODE) {
            // Load table data content
            $tableContent.empty();
            $tableContent.append(res.table);

            // Insert paginate content, specified by the parameter
            $areaPaginate.empty();
            $areaPaginate.append(res.paginate);

            // Auto replace url, when page change
            replaceUrlPagination();

            // Update total result
            changeTotalResultByGroup();
        }
    })
});

/**
 * Sort list ship,
 * Handle sort list ship by column
 *
 * @return void
 */
$(document).on('click', '.th-line-one i', function (event) {
    // Get data sort attribute
    let dataSort = $(this).attr('data-sort');
    // Parse the data with JSON.parse(), the data becomes a JS object
    let obj = JSON.parse($sortValue.val());
    // Get URL from #sort-value
    let url = $sortValue.attr('data-url');
    // Parse search value data to JS object
    let searchValue = JSON.parse($('#value-after-search').val());

    // Set query string to group type and load result, field to sort
    let query = {
        'field': dataSort,
        'load': searchValue.load,
    };

    // Swap order by status, 0: ASC, 1: DESC
    for (var key in obj) {
        if (key === dataSort) {
            obj[key] = (obj[key] === 1) ? 0 : 1;
            query.orderBy = obj[key];
        }
    }

    // Add obj value to sortValue
    $sortValue.val(JSON.stringify(obj));

    // Ajax request to server to sort function
    $.get(url, query, function (res) {
        if (res.code === HTTP_SUCCESS_CODE) {
            // Load table data content
            $tableContent.empty();
            $tableContent.append(res.table);

            // Insert paginate content, specified by the parameter
            $areaPaginate.empty();
            $areaPaginate.append(res.paginate);

            // Restart perfect scroll
            restartScroll();

            // Reset url for sort action
            $sortValue.attr('data-url', url);

            // Replace paginate url
            replaceUrlPagination();

            // Rest url for load record
            $('#load-result').attr('data-url', url);
        }
    });
});

/**
 * Filter ship,
 * Search list ship by column
 *
 * @return void
 */
$(document).on('click', '#btn-filter', function (event) {
    // Get keywords
    let keywords = $(":input").serializeArray();
    // Get data-url
    let url = $(this).attr('data-url') + '?page=1';
    // Handle keywords
    keywords.forEach(function (element, index) {
        if (element.name !== '_token')
            url += '&' + element.name + '=' + element.value;
    });

    // Parse search value data to JS object
    let searchValue = JSON.parse($('#value-after-search').val());

    // Set query string and load result
    let query = {
        'load': searchValue.load,
    };

    // Ajax request to server to filter function
    $.get(url, query, function (res) {
        if (res.code === HTTP_SUCCESS_CODE) {
            // Load table data content
            $tableContent.empty();
            $tableContent.append(res.table);

            // Insert paginate content, specified by the parameter
            $areaPaginate.empty();
            $areaPaginate.append(res.paginate);

            // Restart perfect scroll
            restartScroll();

            // Reset url for sort action
            $('#sort-value').attr('data-url', url);

            // Update total result
            changeTotalResultByGroup();

            // Auto replace url, when page change
            replaceUrlPagination();

            // Rest url for load record
            $('#load-result').attr('data-url', url);
        }
    });
});

/**
 * Show record per page,
 * Choose total record in select box and change record per page
 *
 * @return void
 */
$(document).on('change', '#load-result', function() {
    // Get data-url
    let url = $(this).attr('data-url');

    // Set query string to group type and load result
    let query = {
        'load': $('#load-result').val(),
    };

    // Set value select after click search
    $('#value-after-search').val(JSON.stringify(query));

    // Ajax request to server to show record per page function
    $.get(url, query, function (res) {
        if (res.code === HTTP_SUCCESS_CODE) {
            // Load table data content
            $tableContent.empty();
            $tableContent.append(res.table);

            // Insert paginate content, specified by the parameter
            $areaPaginate.empty();
            $areaPaginate.append(res.paginate);

            // Restart perfect scroll
            restartScroll();

            // Update total result
            changeTotalResultByGroup();

            // Auto replace url, when page change
            replaceUrlPagination();

            // Reset url for sort action
            $('#sort-value').attr('data-url', url);
        }
    });
});

/**
 * Restart perfect scroll
 *
 * @returns void
 */
function restartScroll() {
    const table = document.querySelector('.block-table');
    const psWidth = new PerfectScrollbar(table, function () {
        table.style.width = '100%'
    });

    const content = document.querySelector('.table-content');
    const psHeight = new PerfectScrollbar(content, function () {
        content.style.height = '300px'
    });

    // remove class when init
    $blockTable.removeClass('ps--active-y');
}

/**
 * Replace url paginate when sort data
 *
 * @returns void
 */
function replaceUrlPagination() {
    // Parse the data with JSON.parse(), the data becomes a JS object
    let obj = JSON.parse($sortValue.val());
    let recordPerPage = $('#load-result').val();

    // Set query string
    for (var key in obj) {
        if (obj[key] === 1) {
            query = {
                'field': key,
                'orderBy': obj[key]
            };
            break;
        } else {
            query = {
                'field': '',
                'orderBy': 0
            }
        }
    }

    // Update paginate url
    $('.pagination li').find('a').each(function (index) {
        // Replace url for paginate when sorting
        if ($(this).attr('data-url')) {
            let url = $(this).attr('data-url') + '&field=' + query.field + '&orderBy=' + query.orderBy + '&load=' + recordPerPage;
            $(this).attr('data-url', url);
        }
    });
}

/**
 * Change total filter data result
 */
function changeTotalResultByGroup () {
    $totalResult.empty();
    $totalResult.append($('.table-content .table-result').attr('data-total'));
}
