/**
 * Create js billing paper
 *
 * @package App\Http\Controllers
 * @author quangpm
 * @date 2018/06/19
*/

$( document ).ready(function() {
  initDatePicker();
  initScrollbar();
});

/**
 * Init datetimepicker
 * 
 * @returns void
 */
function initDatePicker() {
  $('#payment-due-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
}

/**
 * Init scrollbar
 * 
 * @returns void
 */
function initScrollbar() {
  var scroll;

  scroll = document.querySelector('#block-tbl-company');
  new PerfectScrollbar(scroll, function () {
    table.style.width = '897px'
  });

  scroll = document.querySelector('.table-list-company tbody');
  new PerfectScrollbar(scroll, function () {
    table.style.height = '675px'
  });
}