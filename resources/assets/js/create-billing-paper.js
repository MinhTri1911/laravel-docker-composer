var billingPaper = new function () {

  this.models = {
    sltStatus : '#slt-status',
    sltApprove : '#slt-approve',
    btnCreate : '#btn-create',
    btnDelivery : '#btn-delivery',
    linkReasonReject : '.link-reason-reject',
    areaInput : '.content-billing',

  }

  // Status approve
  const SELECT_ALL = 0;
  const WAITING_APPROVE = 1;
  const APPROVED = 2;
  const REJECT = 3;

  // Status billing paper
  const NO_CREATE = 1;
  const WAITING_DELIVERY = 2;
  const DELIVERIED = 3;

  this.init = function () {

    billingPaper.events.initDatePicker();
    billingPaper.events.initScrollbar();
    billingPaper.events.initPopup();

    // Event change combobox
    $(document).on('change', billingPaper.models.sltStatus, function () {
      billingPaper.events.displayProcessBilling();
    });
    $(document).on('change', billingPaper.models.sltApprove, function () {
      billingPaper.events.displayProcessBilling();
    });


  }

  this.events = {

   /**
    * Init datetimepicker
    * 
    * @returns void
    */
    initDatePicker: function () {
      $('#payment-due-date').datepicker({
        dateFormat: "yy/mm/dd"
      });
    },

    /**
    * Init scrollbar
    * 
    * @returns void
    */
    initScrollbar: function () {
      var scroll;

      scroll = document.querySelector('#block-tbl-company');
      new PerfectScrollbar(scroll, function () {
        table.style.width = '880px'
      });

      scroll = document.querySelector('.table-list-company tbody');
      new PerfectScrollbar(scroll, function () {
        table.style.height = '675px'
      });
    },

    /**
    * Init popup
    * 
    * @returns void
    */
    initPopup: function () {
      $(document).on('click', billingPaper.models.linkReasonReject, function (e) {
        e.preventDefault();

        $('#modal-reason-reject').modal('show');
      });
    },

    /**
    * Display button billing 
    * 
    * @returns void
    */
    displayProcessBilling: function () {
      var status = $(billingPaper.models.sltStatus).val();
      var approve = $(billingPaper.models.sltApprove).val();

      // Hide control
      $(billingPaper.models.areaInput).removeClass('display-none');
      $(billingPaper.models.btnCreate).removeClass('display-none');
      $(billingPaper.models.btnDelivery).removeClass('display-none');

      // Case select all
      if (approve == SELECT_ALL) {
        if (status == NO_CREATE) {
           $(billingPaper.models.btnDelivery).addClass('display-none');
        }
        if (status == WAITING_DELIVERY || status == DELIVERIED) {
          $(billingPaper.models.areaInput).addClass('display-none'); 
          $(billingPaper.models.btnCreate).addClass('display-none');
        }
      }

      // Case waiting approve
      if (approve == WAITING_APPROVE) {
        $(billingPaper.models.areaInput).addClass('display-none');
        $(billingPaper.models.btnCreate).addClass('display-none');
        $(billingPaper.models.btnDelivery).addClass('display-none');
      }

      // Case approved
      if (approve == APPROVED) {
        if (status == NO_CREATE) {
          $(billingPaper.models.areaInput).addClass('display-none');
          $(billingPaper.models.btnCreate).addClass('display-none');
          $(billingPaper.models.btnDelivery).addClass('display-none');
        }

        if (status == SELECT_ALL || status == WAITING_DELIVERY || status == DELIVERIED) {
          $(billingPaper.models.areaInput).addClass('display-none');
          $(billingPaper.models.btnCreate).addClass('display-none');
        }
      }

      // Case reject
      if (approve == REJECT) {
        $(btnDelivery).addClass('display-none');
        if (status == WAITING_DELIVERY || status == DELIVERIED) {
          $(billingPaper.models.areaInput).addClass('display-none');
          $(billingPaper.models.btnCreate).addClass('display-none');
        }
      }
    },
  }
}

$(document).ready(function () {
    billingPaper.init();
});