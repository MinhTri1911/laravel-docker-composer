/**
 * Create js history billing
 *
 * @package App\Http\Controllers
 * @author quangpm
 * @date 2018/06/19
*/

  var urlBack = '/billing';

$( document ).ready(function() {
  initDatePicker();
  initScrollbar();
  backHistory();
});

/**
 * Init datetimepicker
 * 
 * @returns void
 */
function initDatePicker() {
  $('#start-create-paper-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#end-create-paper-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#start-payment-deadline-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#end-payment-deadline-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#start-payment-actual-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#end-payment-actual-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
}

/**
 * Init datetimepicker popup
 * 
 * @returns void
 */
function initDatePickerPopup() {
  $('#payment-actual-date').datepicker({
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

  scroll = document.querySelector('#block-tbl-history');
  new PerfectScrollbar(scroll, function () {
    table.style.width = '897px'
  });

  scroll = document.querySelector('.table-history tbody');
  new PerfectScrollbar(scroll, function () {
    table.style.height = '675px'
  });
}

/**
 * Show popup update payment date
 * 
 * @returns void
 */
$('.payment-billing').on('click', function (e) {
  e.preventDefault();

  $('#modal-update-payment-date').modal('show');
  initDatePickerPopup();
});

/**
 * Init datetimepicker
 * 
 * @returns void
 */
function initDatePicker() {
  $('#start-create-paper-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#end-create-paper-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#start-payment-deadline-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#end-payment-deadline-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#start-payment-actual-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
  $('#end-payment-actual-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
}

/**
 * Back to history screen
 * 
 * @returns void
 */
function backHistory() {
  $('#btn-back').on('click', function () {
    location.href = $('#url-domain').val() + urlBack;
  });
}