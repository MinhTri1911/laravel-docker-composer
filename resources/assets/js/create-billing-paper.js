/**
 * Create js billing paper
 *
 * @package App\Http\Controllers
 * @author quangpm
 * @date 2018/06/19
*/

  // ID controll
  var sltStatus = '#slt-status';
  var sltApprove = '#slt-approve';
  var btnCreate = '#btn-create';
  var btnDelivery = '#btn-delivery';

  // Status approve
  const SELECT_ALL = 0;
  const WAITING_APPROVE = 1;
  const APPROVED = 2;
  const REJECT = 3;

  // Status billing paper
  const NO_CREATE = 1;
  const WAITING_DELIVERY = 2;
  const DELIVERIED = 3;

// Event when loaded document
$( document ).ready(function() {
  initDatePicker();
  initScrollbar();

  // Event change combobox
  $(sltStatus).on('change', function () {
    displayProcessBilling();
  });
  $(sltApprove).on('change', function () {
    displayProcessBilling();
  });
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
    table.style.width = '880px'
  });

  scroll = document.querySelector('.table-list-company tbody');
  new PerfectScrollbar(scroll, function () {
    table.style.height = '675px'
  });
}

/**
 * Event change combobox
 * 
 * @returns void
 */
function changeDataCombobox() {
  $(sltStatus).on('change', function () {
    displayProcessBilling();
  });
}

/**
 * Display process billing 
 * 
 * @returns void
 */
function displayProcessBilling() {
  var status = $(sltStatus).val();
  var approve = $(sltApprove).val();

  // Hide control
  $('.content-billing').removeClass('display-none');
  $(btnCreate).removeClass('display-none');
  $(btnDelivery).removeClass('display-none');

  // Case select all
  if (approve == SELECT_ALL) {
    if (status == NO_CREATE) {
       $(btnDelivery).addClass('display-none');
    }
    if (status == WAITING_DELIVERY || status == DELIVERIED) {
      $('.content-billing').addClass('display-none'); 
      $(btnCreate).addClass('display-none');
    }
  }

  // Case waiting approve
  if (approve == WAITING_APPROVE) {
    $('.content-billing').addClass('display-none');
    $(btnCreate).addClass('display-none');
    $(btnDelivery).addClass('display-none');
  }

  // Case approved
  if (approve == APPROVED) {
    if (status == NO_CREATE) {
      $('.content-billing').addClass('display-none');
      $(btnCreate).addClass('display-none');
      $(btnDelivery).addClass('display-none');
    }

    if (status == SELECT_ALL || status == WAITING_DELIVERY || status == DELIVERIED) {
      $('.content-billing').addClass('display-none');
      $(btnCreate).addClass('display-none');
    }
  }

  // Case reject
  if (approve == REJECT) {
    $(btnDelivery).addClass('display-none');
    if (status == WAITING_DELIVERY || status == DELIVERIED) {
      $('.content-billing').addClass('display-none');
      $(btnCreate).addClass('display-none');
    }
  }
}
