var HTTP_SUCCESS = 200;
var HTTP_ERROR = 500;

var billingPaper = new function () {

  this.models = {

    // Button
    btnCreate: '#btn-create',
    btnDelivery: '#btn-delivery',
    btnSearch: '#btn-search',
    btnRadioCompany: '.btn-radio-company',
    btnExportCsv: '#btn-export-csv',

    linkReasonReject: '.link-reason-reject',
    areaInput: '.content-billing',
    areaResultSearch: '#area-tbl-result',

    // Item controll
    txtCompanyName: '#company-name',
    sltStatus: '#slt-status',
    sltApprove: '#slt-approve',
    sltStartYear: '#slt-start-year',
    sltEndYear: '#slt-end-year',
    sltStartMonth: '#slt-start-month',
    sltEndMonth: '#slt-end-month',
    sltNumberRecord: '#slt-number-record',
    linkPagination: '.pagination li a',
    lblRadioCompany: '.lbl-radio-company',
    txtRemark: '#txt-remark',
    chkDetail: '#chk-detail',
    statusBilling: '#hidden-status-',
    totalRecord: '#total-record',

    // Url
    urlSearch: '#url-search',
    urlCreate: '#url-create',
    urlDelivery: '#url-delivery',
    urlExport: '#url-export-csv',

    // Popup
    popupReasonReject: '#modal-reason-reject',
    popupReasonRejectText: '#popup-reason-reject-text',
    popupConfirm: '#modal-confirm',
    popupConfirmTitle: '#title-popup-confirm',
    popupConfirmText: '#popup-confirm-text',
    btnConfirmCancel: '#btn-confirm-cancel',
    btnConfirmOk: '#btn-confirm-ok',
    popupInform: '#modal-inform',
    titlePopupInform: '#title-popup-inform',
    messagePopupInform: '#popup-inform-message'

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

  // Domain
  const DOMAIN = location.protocol + "//" + location.host + '/';
  
  // KEY ENTER
  const KEY_ENTER = 13;

  this.url = {
    searchBillingPaper: $(this.models.urlSearch).val(),
    createBillingPaper: $(this.models.urlCreate).val(),
    deliveryBillingPaper: $(this.models.urlDelivery).val(),
    exportBillingPaper: $(this.models.urlExport).val()
  };

  this.init = function () {

    // Clear localStorage
    var param = {
      'conditionSearch': {
        'companyName': null,
        'status': $(billingPaper.models.sltStatus).val(),
        'approve': $(billingPaper.models.sltApprove).val(),
        'startYear': $(billingPaper.models.sltStartYear).val(),
        'startMonth': $(billingPaper.models.sltStartMonth).val(),
        'endYear': $(billingPaper.models.sltEndYear).val(),
        'endMonth': $(billingPaper.models.sltEndMonth).val(),
        'numberRecord': $(billingPaper.models.sltNumberRecord).val()
      }
    };
    window.localStorage.setItem(ID_SCREEN, JSON.stringify(param));

    billingPaper.events.initPopup();

    // Event change combobox
    $(document).on('change', billingPaper.models.sltStatus, function () {
      billingPaper.events.displayProcessBilling();
    });
    $(document).on('change', billingPaper.models.sltApprove, function () {
      billingPaper.events.displayProcessBilling();
    });

    // Search when press key enter
    $(document).on('keyup', billingPaper.models.txtCompanyName, function (e) {
      e.preventDefault();
      if(e.keyCode == KEY_ENTER) {
        billingPaper.events.searchBillingPaper();
      }
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

      localStorage['companyId'] = $('#' + btnRadioId).val();
      window.localStorage.setItem(ID_SCREEN, JSON.stringify(localStorage));
    });

    // Click button create billing paper
    $(document).on('click', billingPaper.models.btnCreate, function () {
      billingPaper.events.createBillingPaper();
    });

    // Click button delivery billing paper
    $(document).on('click', billingPaper.models.btnDelivery, function () {
      billingPaper.events.deliveryBillingPaper();
    });

    // Click button ok confirm delivery billing paper
    $(document).on('click', billingPaper.models.btnConfirmOk, function () {
      billingPaper.events.deliverySubmit();
      $(billingPaper.models.popupConfirm).modal('hide');
    });

    // Export CSV billing paper
    $(document).on('click', billingPaper.models.btnExportCsv, function () {
      billingPaper.events.export();
    });
  };

  this.events = {

    /**
     * Init popup
     *
     * @returns void
     */
    initPopup: function () {
      $(document).on('click', billingPaper.models.linkReasonReject, function (e) {
        e.preventDefault();

        // Set reason reject
        idRejectText = $(this).attr('id-for');
        contentReason = $(idRejectText).val();
        $(billingPaper.models.popupReasonRejectText).html(contentReason);

        $(billingPaper.models.popupReasonReject).modal('show');
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
        'conditionSearch': {
          'companyName': $(billingPaper.models.txtCompanyName).val(),
          'status': $(billingPaper.models.sltStatus).val(),
          'approve': $(billingPaper.models.sltApprove).val(),
          'startYear': $(billingPaper.models.sltStartYear).val(),
          'startMonth': $(billingPaper.models.sltStartMonth).val(),
          'endYear': $(billingPaper.models.sltEndYear).val(),
          'endMonth': $(billingPaper.models.sltEndMonth).val(),
          'numberRecord': $(billingPaper.models.sltNumberRecord).val()
        },
        'page' : 1
      };

      // Ajax
      $.get(billingPaper.url.searchBillingPaper, param, function (res) {
        if (res.code === HTTP_SUCCESS) {

          // Set localstorage
          window.localStorage.setItem(ID_SCREEN, JSON.stringify(param));

          //Render partialview after call ajax
          billingPaper.events.renderPartialView(res);
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
          param['conditionSearch']['numberRecord'] = $(billingPaper.models.sltNumberRecord).val();
          param['page'] = 1;
        } else {
          param['page'] = $(item).html();
        }

        // Ajax
        $.get(billingPaper.url.searchBillingPaper, param, function (res) {
          if (res.code === HTTP_SUCCESS) {

            // Set localstorage
            window.localStorage.setItem(ID_SCREEN, JSON.stringify(param));

           //Render partialview after call ajax
            billingPaper.events.renderPartialView(res);

            // Set radio checked
            billingPaper.events.autoCheckedRadioCompany(param['companyId']);
          }
        })
          .fail(function (res) {
            // Set display item
            billingPaper.events.displayProcessBilling();

            return;
          });
      }
    },

    /**
     * Check value and checked radio button
     *
     * @param int companyId
     * @returns void
     */
    autoCheckedRadioCompany: function (companyId) {

      if (companyId !== undefined && companyId !== null) {
        $(billingPaper.models.btnRadioCompany).each(function () {
          if (companyId == $(this).val()) {
            $(this).prop('checked', true);
            return true;
          }
        });
      }
    },

    /**
     * Create billing paper
     *
     * @returns void
     */
    createBillingPaper: function () {

      var companyId = $("input:radio[name='rdo_company']:checked").val();

      // Create parameter
      var param = JSON.parse(window.localStorage.getItem(ID_SCREEN));
      param['createBillingPaper'] = {
        'companyId': companyId,
        'remark': $(billingPaper.models.txtRemark).val(),
        'isDetail': $("input:checkbox[name='is_detail']:checked").val()
      };

      // Ajax
      $.post(billingPaper.url.createBillingPaper, param, function (res) {
        if (res.code === HTTP_SUCCESS) {

          // Show alert inform
          $(billingPaper.models.titlePopupInform).html(res.title);
          $(billingPaper.models.messagePopupInform).html(res.message);
          $(billingPaper.models.popupInform).modal('show');

        } else {
          // Show alert inform
          $(billingPaper.models.titlePopupInform).html(res.title);
          $(billingPaper.models.messagePopupInform).html(res.message);
          $(billingPaper.models.popupInform).modal('show');
        }

        //Render partialview after call ajax
        billingPaper.events.renderPartialView(res);
      })
        .fail(function (res) {
          // Set display item
          billingPaper.events.displayProcessBilling();

          return;
        });
    },

    /**
     * Delivery billing paper
     *
     * @returns void
     */
    deliveryBillingPaper: function () {

      var companyId = $("input:radio[name='rdo_company']:checked").val();

      // Show inform when billing paper delivered
      if (DELIVERIED == $(billingPaper.models.statusBilling + companyId).val()) {

        // Show alert inform
        $(billingPaper.models.popupConfirmTitle).html(message.popup_confirm_delivery_title);
        $(billingPaper.models.popupConfirmText).html(message.msg_confirm_delivery_again);
        $(billingPaper.models.popupConfirm).modal('show');
      } else {
        billingPaper.events.deliverySubmit();
      }
    },

    /**
     * Submit delivery billing paper
     *
     * @returns void
     */
    deliverySubmit: function () {

      var historyBillingId = $("input:radio[name='rdo_company']:checked").attr('hb-id');

      // Create parameter
      var param = JSON.parse(window.localStorage.getItem(ID_SCREEN));
      param['deliveryBillingPaper'] = {
        'historyBillingId' : historyBillingId
      };

      // Ajax
      $.post(billingPaper.url.deliveryBillingPaper, param, function (res) {

        //Render partialview after call ajax
        billingPaper.events.renderPartialView(res);

        if (res.code === HTTP_SUCCESS) {

          // Show alert inform
          if (res.pdf_url === undefined) {
            $(billingPaper.models.titlePopupInform).html(res.title);
            $(billingPaper.models.messagePopupInform).html(res.message);
            $(billingPaper.models.popupInform).modal('show');
          } else {
            $url = DOMAIN + res.pdf_url;
            window.open($url, '_blank');
          }

        } else {
          // Show alert inform
          $(billingPaper.models.titlePopupInform).html(res.title);
          $(billingPaper.models.messagePopupInform).html(res.message);
          $(billingPaper.models.popupInform).modal('show');
        }

      })
        .fail(function (res) {
          // Set display item
          billingPaper.events.displayProcessBilling();
          return;
        });
    },

    /**
     * Export billing paper
     *
     * @returns void
     */
    export: function () {

      // Create parameter
      var param = JSON.parse(window.localStorage.getItem(ID_SCREEN));
      param['conditionSearch']['numberRecord'] = $(billingPaper.models.totalRecord).val();

      // Ajax
      $.post(billingPaper.url.exportBillingPaper, param, function (res) {
        if (res.code === HTTP_ERROR) {
          // Show alert inform
          $(billingPaper.models.titlePopupInform).html(res.title);
          $(billingPaper.models.messagePopupInform).html(res.message);
          $(billingPaper.models.popupInform).modal('show');
        } else {

          // Create element a
          var a = document.createElement("a");
          document.body.appendChild(a);
          a.style = "display: none";

          // Create url
          var blob = new Blob([res], {type: "octet/stream"}),
            url = window.URL.createObjectURL(blob);
          a.href = url;

          // Download file
          a.download = message.export_file_name + '.csv';
          a.click();
          window.URL.revokeObjectURL(url);
        }

        // Set display item
        billingPaper.events.displayProcessBilling();
      })
        .fail(function (res) {
          // Set display item
          billingPaper.events.displayProcessBilling();
          return;
        });
    },
    
    /**
     * Render partialview after call ajax
     * 
     * @param object res response
     * @returns void
     */
    renderPartialView: function (res){
      // Append data
      if (res.html !== undefined) {
        $(billingPaper.models.areaResultSearch).empty();
        $(billingPaper.models.areaResultSearch).append(res.html);
      }

      // Set display item
      billingPaper.events.displayProcessBilling();

      // Init select2
      Events.initSelect2();
    }

  };
};

$(document).ready(function () {
  billingPaper.init();
});