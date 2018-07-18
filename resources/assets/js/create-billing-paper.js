var HTTP_SUCCESS = 200;
var HTTP_ERROR = 500;

var billingPaper = new function () {

  this.models = {

    // Button
    btnCreate : '#btn-create',
    btnDelivery : '#btn-delivery',
    btnSearch : '#btn-search',

    linkReasonReject : '.link-reason-reject',
    areaInput : '.content-billing',
    areaResultSearch : '#area-tbl-result',

    // Item controll
    txtCompanyName : '#company-name',
    sltStatus : '#slt-status',
    sltApprove : '#slt-approve',
    sltStartYear: '#slt-start-year',
    sltEndYear: '#slt-end-year',
    sltStartMonth: '#slt-start-month',
    sltEndMonth: '#slt-end-month',
    sltNumberRecord: '#slt-number-record',
    popupReasonRejectText : '#popup-reason-reject-text',
    linkPagination : '.pagination li a',
    lblRadioCompany : '.lbl-radio-company',
    btnRadioCompany : '.btn-radio-company',

    // Url
    urlSearch : '#url-search'
  };

  // Status approve
  const ID_SCREEN = 'BBA0001';

  // Status approve
  const SELECT_ALL = 0;
  const WAITING_APPROVE = 1;
  const APPROVED = 2;
  const REJECT = 3;

  // Status billing paper
  const NO_CREATE = 1;
  const WAITING_DELIVERY = 2;
  const DELIVERIED = 3;
  
  this.url = {
    searchBillingPaper: $(this.models.urlSearch).val()
  };

  this.init = function () {

    // Clear localStorage
    var param = {
          'conditionSearch' : {
              'companyName' : null,
              'status': $(billingPaper.models.sltStatus).val(),
              'approve': $(billingPaper.models.sltApprove).val(),
              'startYear': $(billingPaper.models.sltStartYear).val(),
              'startMonth': $(billingPaper.models.sltStartMonth).val(),
              'endYear': $(billingPaper.models.sltEndYear).val(),
              'endMonth': $(billingPaper.models.sltEndMonth).val(),
              'numberRecord' : $(billingPaper.models.sltNumberRecord).val()
            }
        };
    window.localStorage.setItem(ID_SCREEN, JSON.stringify(param));

    //    billingPaper.events.initScrollbar();
    billingPaper.events.initPopup();

    // Event change combobox
    $(document).on('change', billingPaper.models.sltStatus, function () {
      billingPaper.events.displayProcessBilling();
    });
    $(document).on('change', billingPaper.models.sltApprove, function () {
      billingPaper.events.displayProcessBilling();
    });

    // Event search
    $(document).on('click', billingPaper.models.btnSearch, function () {
      billingPaper.events.searchBillingPaper();
    });
    $(document).on('change', billingPaper.models.sltNumberRecord, function (e) {
      billingPaper.events.searchPagination(this, e, 1);
    });
    $(document).on('click', billingPaper.models.linkPagination, function (e) {
      billingPaper.events.searchPagination(this, e, 2);
    });

    // Choose radio company and save into localstore
    $(document).on('click', billingPaper.models.lblRadioCompany, function () {

      var localStorage = JSON.parse(window.localStorage.getItem(ID_SCREEN));
      var btnRadioId = $(this).attr('for');

      localStorage['companyId']  = $('#' + btnRadioId).val();
      window.localStorage.setItem(ID_SCREEN, JSON.stringify(localStorage));
    });

    // Click button create billing paper
    $(document).on('click', billingPaper.models.btnCreate, function () {
      billingPaper.events.createBillingPaper();
    });

  };

  this.events = {

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

        idRejectText = $(this).attr('id-for');
        contentReason = $(idRejectText).val();
        $(billingPaper.models.popupReasonRejectText).html(contentReason);

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
        $(billingPaper.models.btnDelivery).addClass('display-none');
        if (status == WAITING_DELIVERY || status == DELIVERIED) {
          $(billingPaper.models.areaInput).addClass('display-none');
          $(billingPaper.models.btnCreate).addClass('display-none');
        }
      }
    },

    /**
     * Search billing paper
     * 
     * @returns void}
     */
    searchBillingPaper: function () {

      var param = {
        'conditionSearch' : {
            'companyName' : $(billingPaper.models.txtCompanyName).val(),
            'status': $(billingPaper.models.sltStatus).val(),
            'approve': $(billingPaper.models.sltApprove).val(),
            'startYear': $(billingPaper.models.sltStartYear).val(),
            'startMonth': $(billingPaper.models.sltStartMonth).val(),
            'endYear': $(billingPaper.models.sltEndYear).val(),
            'endMonth': $(billingPaper.models.sltEndMonth).val(),
            'numberRecord' : $(billingPaper.models.sltNumberRecord).val()
          }
      };

      // Ajax
      $.get(billingPaper.url.searchBillingPaper, param, function (res) {
        if (res.code === HTTP_SUCCESS) {

          // Set localstorage
          window.localStorage.setItem(ID_SCREEN, JSON.stringify(param));

          // Append data
          $(billingPaper.models.areaResultSearch).empty();
          $(billingPaper.models.areaResultSearch).append(res.html);

        }
      })
      .fail(function (res) {
          return;
      });
    },

    /**
     * Search pagination billing paper
     * 
     * @param object item item of event
     * @param object event event
     * @param int itemType 1: numberRecord, 2: link pagination
     * @returns void
     */
    searchPagination: function (item, event, itemType) {
      event.preventDefault();

      var param = JSON.parse(window.localStorage.getItem(ID_SCREEN));

      // Get condition search from screen
      if (param !== null) {
        if (itemType == 1) {
          param['page'] = 1;
          param['conditionSearch']['numberRecord'] = $(billingPaper.models.sltNumberRecord).val();
        } else {
          param['page'] = $(item).html();
        }

        // Ajax
        $.get(billingPaper.url.searchBillingPaper, param, function (res) {
          if (res.code === HTTP_SUCCESS) {

            // Set localstorage
            window.localStorage.setItem(ID_SCREEN, JSON.stringify(param));

            // Append data
            $(billingPaper.models.areaResultSearch).empty();
            $(billingPaper.models.areaResultSearch).append(res.html);

            // Set radio checked
            billingPaper.events.autoCheckedRadioCompany(param['companyId']);
          }
        })
        .fail(function (res) {
            return;
        });
      }
    },

    /**
     * Check value and checked radio button
     * 
     * @returns void
     */
    autoCheckedRadioCompany: function (companyId) {

      if (companyId !== undefined && companyId !== null) {
        $(billingPaper.models.btnRadioCompany).each(function() {
          if (companyId == $(this).val()) {
            $(this).prop('checked', true);
            return true;
          }
        });
      }

    },
    
    /**
     * 
     * @returns void
     */
    createBillingPaper : function () {
      
    }
  };
};

$(document).ready(function () {
    billingPaper.init();
});