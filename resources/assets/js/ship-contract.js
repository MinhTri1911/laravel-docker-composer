$(function(){
    // Handle check lisst    
    Handler.initial();
    
    /**
     * Show popup modal confirm restore contract
     */   
    $(document).on("click",".restore-contract", function(){
        var service = $(this).data('service');
        var data = {
            'ship': $(this).data('ship'),
            'contract': $(this).data('contract')
        };
        
        Handler.typeModal = "restore";
        Handler.modalPopup.title = ShipModal.modalContractRestore.title || "";
        Handler.modalPopup.message = service + (ShipModal.modalContractRestore.message || "");
        Handler.showPopupRestore(data);
    });
     
    /**
     * Show popup modal confirm disable contract
     */
    $(document).on("click",".disable-contract", function(){
        var idContracts = '';
        
        //When not select any contract, alert error else show popup
        if(Handler.checkList.length > 0){
            Handler.checkList.forEach(function(value){
                idContracts += value+':';
            });
            
            var data = {
                'ship': $(this).data('ship'),
                'contract': idContracts.substr(0, idContracts.lastIndexOf(":"))
            };

            Handler.typeModal = "disable";
            Handler.modalPopup.title = ShipModal.modalContractDisable.title || "";
            Handler.modalPopup.message = ShipModal.modalContractDisable.message || "";
            Handler.showPopupDisable(data);
        }else{
            Handler.typeModal = "";
            Handler.contract.isDisable = false;
            Handler.modalDone.title = ShipModal.modalContractDisable.title_error || "";
            Handler.modalDone.message = ShipModal.modalContractDisable.message_error || "";
            Handler.showPopupDoneDisableContract();
        }
    });
    
    /**
     * Show popup modal confirm delete contract
     */
    $(document).on("click",".delete-contract", function(){
        var idContracts = '';
        
        //When not select any contract, alert error else show popup 
        if(Handler.checkList.length > 0){
            Handler.checkList.forEach(function(value){
                idContracts += value+':';
            });
            var data = {
                'ship': $(this).data('ship'),
                'contract': idContracts.substr(0, idContracts.lastIndexOf(":"))
            };
            Handler.typeModal = "delete";
            Handler.modalPopup.title = ShipModal.modalContractDelete.title || "";
            Handler.modalPopup.message = ShipModal.modalContractDelete.message || "";
            Handler.showPopupDelete(data);
        }else{
            Handler.typeModal = "";
            Handler.contract.isDelete = false;
            Handler.modalDone.title = ShipModal.modalContractDelete.title_error || "";
            Handler.modalDone.message = ShipModal.modalContractDelete.message_error || "";
            Handler.showPopupDoneDeleteContract();
        }
    });
    
    /**
     * Show popup modal confirm delete spot
     * Click cancel button, hide popup
     * Click OK, process delete spot and show popup alert success or fail
     */  
    $(document).on("click",".delete-spot", function(){
        var data = {
            'ship': $(this).data('ship'),
            'spot': $(this).data('spot')
        };
        
        Handler.typeModal = "delete-spot";
        Handler.modalPopup.title = ShipModal.modalSpotDelete.title || "";
        Handler.modalPopup.message = $(this).data('spot')+ (ShipModal.modalSpotDelete.message || "");
        Handler.showPopupDeleteSpot(data);
    });
    
    /**
     * Click button OK, handle process flow base on type modal
     * If is modal auth, the show input password
     */
    $(document).on('click', '#modalBtnOK', function(e){
        if(Handler.typeModal != "" && Handler.typeModal == "restore"){
            Handler.ajaxRestoreContract($(this));
        }else if(Handler.typeModal != "" && Handler.typeModal == "disable"){
            Handler.ajaxDisableContract($(this));
        }else if(Handler.typeModal != "" && Handler.typeModal == "delete"){
            Handler.ajaxDeleteContract($(this));
        }else if(Handler.typeModal != "" && Handler.typeModal == "delete-spot"){
            Handler.ajaxDeleteSpot($(this));
        }else if(Handler.typeModal != "" && Handler.typeModal == "delete-ship"){
            Handler.showModalAuth();
        }
    });
    
    /**
     * Show popup view reason reject approve
     */
    $(document).on("click",".view-reason", function(){
        Handler.showPopupReject($(this));
    });
    
    /**
     * Show popup modal confirm delete ship
     * Click OK, show popup contain input password
     * Click cancel, hide popup
     */
    $(document).on("click",".delete-ship", function(){
        var data = {
            'ship': $(this).data('ship')
        };

        Handler.typeModal = "delete-ship";
        Handler.modalPopup.title = ShipModal.modalShipDelete.title || "";
        Handler.modalPopup.message = ShipModal.modalShipDelete.message || "";
        Handler.showPopup(data);
        
    });
    
    /**
     * Show popup allow user input password to author before delete ship
     * Click OK, handle delete ship and show message success or failed
     */
    $(document).on('click', '#modalBtnOKAuth', function(e){
        Handler.ajaxDeleteShip($(this));
    });
    
});

/**
 * Object handler processing funtion or follow processing
 * Show popup contract and spot
 */
var Handler = {
    /**
     * Initialize controls and lib need to use for script file
     * Reset lib and initial lib
     */
    initial: function(){
        this.handleCheckList("#chk_ct_full", "input[name='contract']");
        var vThis = this;
        
        // Remove attribute after append to
        $("#modal-confirm").on('hide.bs.modal', function(){
            $("#modal-confirm").find('#modalBtnOK').removeAttr('data-ship data-contract');
            vThis.contract.isDisable = false;
            vThis.contract.isDelete = false;
        });
        
        $("#modal-auth").on('hide.bs.modal', function(){
            vThis.ship.isDelete = false;
            vThis.isNext = false;
            $('#ship-del-error').text('');
            $('#pw-user').val('');
        });
        
        // Pjax when click paginate of spot
        $(document).pjax('ul.pagination li a', '.content-load');
        
        // Config pjax for system
        if ($.support.pjax) {
            $.pjax.defaults.timeout = 60000; // time in milliseconds
            $.pjax.defaults.scrollTo = false;
        }
        
        // Reset lib
        $(document).on('ready pjax:end', function() {
            vThis.initialPlugin();
        });
        
        $(document).on('pjax:popstate', function() {
            $.pjax.reload('.content-load');
        });
        
        // Handle pjax when click limit page
        vThis.limitPage();
        
        var tbody_f = document.querySelectorAll('.modal');
        for (var i = 0; i < tbody_f.length; i++) {
            const ps2 = new PerfectScrollbar(tbody_f[i], {
                wheelSpeed: 0.1,
                minScrollbarLength: 90
            });
        }
    },
    
    /**
     * Check type modal to handle event each to
     * @type String
     */
    typeModal: '',
    
    /**
     * Text status config for contract and spot
     * @type Object
     */
    typo: {
        stt_active: ShipModal.typo.stt_active || "",
        stt_pending: ShipModal.typo.stt_pending || "",
        stt_finish: ShipModal.typo.stt_finish || "",
        
        apv_done: ShipModal.typo.apv_done || "",
        apv_pending: ShipModal.typo.apv_pending || "",
        apv_reject: ShipModal.typo.apv_reject || ""
    },
    
    /**
     * Control button restore
     * @type element
     */
    control: {
        btn_restore: '<button class="btn btn-orange btn-custom-sm restore-contract restore-contract-1" data-service="service1" data-ship="1" data-contract="1">復活</button>'
    },
    
    /**
     * Info modal popup when click delete
     */
    modalPopup: {
      title: "Title",
      message: "Message",
      isClickOk: false,
      afterShowPopup: false
    },
    
    /**
     * Info modal popup when click delete
     */
    modalDone: {
        title: "Title done",
        message: "Message done"
    },
    
    /**
     * Info modal popup when click delete
     * @type Object
     */
    modalAuth: {
        isAuth: false,
        error_emp: ShipModal.modalAuth.message_error_pw || "",
        redirectAfterDone: '/ship'
    },
    
    /**
     * Info modal popup when click delete
     * @type Object
     */
    contract: {
        isRestore: false,
        isDisable: true,
        isDelete: true
    },
    
    /**
     * Info modal popup when click delete
     * @type Object
     */
    spot: {
        isDelete: false
    },
    
    // Config ship
    ship:{
        isDelete: true
    },
    
    
    /**
     * Check list
     * @type Array
     */
    checkList: [],
    
    /**
     * Only show popup done fater handle. Eg: Show alert success, or error, etc...
     * @type Boolean
     */
    isOnlyPoupDone: false,
    
    /**
     * Handle checked for each item check and global check all
     * 
     * @param element elementAllCheck
     * @param element elementItemCheck
     */
    handleCheckList: function(elementAllCheck, elementItemCheck) {
        // Check all checkbox
        var vThis = this;
        $(document).on('change', elementAllCheck, function(e) {
           if ($(this).is(':checked')){
               $(elementItemCheck).prop('checked', true).trigger('change');
           } else {
               vThis.checkList = [];
               $(elementItemCheck).prop('checked', false);
           }
        });
        
        // When check item with status checked and check all
        $(document).on('change', elementItemCheck, function(e) {
           if (!$(this).is(':checked')) {
               $(elementAllCheck).prop('checked', false);
               if (vThis.checkList.length > 0) {
                   var i = vThis.checkList.indexOf($(this).attr('id').replace(/[^0-9]+/, ""));
                    if(i != -1) {
                        vThis.checkList.splice(i, 1);
                    }
               }
           } else {
               var checked_ch = $(elementItemCheck+":checked");
               vThis.checkList.push($(this).attr('id').replace(/[^0-9]+/, ""));
               if (checked_ch.length == $(elementItemCheck).length) {
                   $(elementAllCheck).prop('checked', true);
               }
           }
        });
    },
    
    /**
     * Check list checking
     * 
     * @param {type} el
     * @returns {Array|Handler.itemChecking.els}
     */
    itemChecking: function(el) {
        var els = [];
        if (el != null && typeof el != typeof undefined) {
            var checkingEl = $(el+":checked");
            checkingEl.each(function(index, el){
                els.push(el);
            });
        }
        return els;
    },
    
    /**
     * Check list checking
     * 
     * @param {type} el
     * @returns {Array|Handler.itemChecking.els}
     */
    clearChecking: function(elementItemCheck) {
        $(elementItemCheck).prop('checked', false).trigger('change');
    },
    
    /**
     * Show popup confirm restore
     * 
     * @param {type} data
     * @returns {undefined}
     */
    showPopup: function(data) {
        $('#modalTitle').text(this.modalPopup.title);
        $('#modalMessage').html(this.modalPopup.message);
        $("#modal-confirm").modal("show");
        $("#modal-confirm").on("shown.bs.modal", function(){
            if (!$("body").hasClass('modal-open')) {
                $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
            }
        });
        
        // Set data for btn ok
        if (typeof data != typeof undefined) {
            for (var key in data) {
                $("#modal-confirm").find('#modalBtnOK').attr('data-'+key, data[key]);
            }
        }
    },
    
    /**
     * Hide popup confirm
     * @returns {undefined}
     */
    hidePopup: function() {
        $("#modal-confirm").modal("hide");
        $('body').removeClass('modal-open').attr('style', $('body').attr('style').replace('padding-right: 17px;', ''));
    },
    
    /**
     * Function handle error exception
     * 
     * @param {type} error
     * @returns {undefined}
     */
    errorHandler: function(error){
//        $('#modalTitleDone').text("Error");
//        $('#modalMessageDone').text(error.responseText);
//        $("#modal-done").modal("show");
//        $("#modal-done").on('shown.bs.modal', function() {
//            if (!$("body").hasClass('modal-open')) {
//                $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
//            }
//        });
        $('.modal').modal('hide');
//        window.location.reload();
    },
    
    /**
     * Show modal confirm restore contract
     * 
     * @param data [Pass param into button]
     * @returns Modal
     */
    showPopupRestore: function(data){
        var vThis = this;
        vThis.showPopup(data);
    },
    
    /**
     * Show alert after handle restore
     * @returns Modal
     */
    showPopupDoneRestoreContract: function(){
        var vThis = this;
        $('#modalTitleDone').text(vThis.modalDone.title);
        $('#modalMessageDone').text(vThis.modalDone.message);
        $("#modal-done").modal("show");
        $("#modal-done").on("shown.bs.modal", function(){
            if(!$("body").hasClass('modal-open')){
                $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
            }
        });
    },
    reloadContract: function() {
        $.pjax({
            url: window.location.href,
            container: '.content-contract'
        });
    },
    
    /**
     * Ajax handle restore contracts
     * 
     * @param Element el
     * @returns Response
     */
    ajaxRestoreContract: function(el){
        var vThis = this;
        var ship_id = el.attr('data-ship');
        var contract_id = el.attr('data-contract');
        $.ajax({
            type: "POST",
            data: {"contract_id": contract_id, "ship_id": ship_id},
            url: '/ship/restore-contract',
            success: function(){
                vThis.hidePopup();
            },
            error: function(error){
                vThis.errorHandler(error);
            }
         }).done(function(data){
             if(typeof data.redirectTo != typeof undefined){
                 window.location.href = data.redirectTo;
             }else{
                 if(typeof data.status != typeof undefined && data.status == true){
                    vThis.modalDone.title = data.title;
                    vThis.modalDone.message = data.message;
                    vThis.showPopupDoneRestoreContract();
                    vThis.uiAfterRestoreContract(data);
                    vThis.clearChecking("input[name='contract']");
                 }else{
                    console.log(data);
                    vThis.modalDone.title = data.title;
                    vThis.modalDone.message = data.message;
                    vThis.showPopupDoneRestoreContract();
                 }
             }
         }); 
    },
    
    /**
     * Change text status and approve after restore
     * @param {type} res
     * @returns {undefined}
     */
    uiAfterRestoreContract: function(res){
        $('.restore-contract-'+res.contract).remove();
        $('.edit-contract-'+res.contract).remove();
        $('.status-contract-'+res.contract).text(this.typo.stt_active);
        $('.approve-contract-'+res.contract).text(this.typo.apv_pending);
        this.reloadContract();
    },
    
    /**
     * Show modal confirm disable
     * 
     * @param {type} data
     * @returns {undefined}
     */
    showPopupDisable: function(data){
        var vThis = this;
        vThis.showPopup(data);
    },
    
    /**
     * 
     * @param {type} data
     * @returns {undefined}
     */
    showPopupErrorDisable: function(data){
        var vThis = this;
        vThis.showPopup(data);
    },
    
    showPopupDoneDisableContract: function(){
        var vThis = this;
        $('#modalTitleDone').text(vThis.modalDone.title);
        $('#modalMessageDone').html(vThis.modalDone.message);
        $("#modal-done").modal("show");
        $("#modal-done").on('shown.bs.modal', function() {
            if (!$("body").hasClass('modal-open')) {
                $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
            }
        });
    },
    
    /**
     * Ajax handle disable contracts
     * 
     * @param {type} el
     * @returns {undefined}
     */
    ajaxDisableContract: function(el){
        var vThis = this;
        var ship_id = el.attr('data-ship');
        var contract_id = el.attr('data-contract');
        $.ajax({
            type: "POST",
            data: {"contract_id": contract_id, "ship_id": ship_id},
            url: '/ship/disable-contract',
            success: function(){
                vThis.hidePopup();
            },
            error: function(error){
                vThis.errorHandler(error);
            }
         }).done(function(data){
             vThis.isNext = true;
             vThis.contract.isDisable = true;
             
            if (typeof data.status != typeof undefined && data.status == true) {
                vThis.modalDone.title = data.title;
                vThis.modalDone.message = data.message;
                vThis.showPopupDoneDisableContract();
                vThis.uiAfterDisableContract(data);
                vThis.clearChecking("input[name='contract']");
            } else {
                vThis.modalDone.title = data.title;
                vThis.modalDone.message = data.message;
                vThis.showPopupDoneDisableContract();
            }
        }); 
    },
    
    /**
     * 
     * @param {type} res
     * @returns {undefined}
     */
    uiAfterDisableContract: function(res){
        if(typeof res.contracts != typeof undefined){
            for(var i = 0; i < res.contracts.length; i++){
                $('.status-contract-'+res.contracts[i]).text(this.typo.stt_pending);
                $('.approve-contract-'+res.contracts[i]).text(this.typo.apv_pending);
            }
            this.reloadContract();
        }
    },
    
    showPopupDelete: function(data) {
        var vThis = this;
        vThis.showPopup(data);
    },
    
    showPopupErrorDelete: function(data) {
        var vThis = this;
        vThis.showPopup(data);
    },
    
    /**
     * Show popup aelrt message after delete contract
     * 
     * @return Modal
     */
    showPopupDoneDeleteContract: function() {
        var vThis = this;
        $('#modalTitleDone').text(vThis.modalDone.title);
        $('#modalMessageDone').html(vThis.modalDone.message);
        $("#modal-done").modal("show");
        $("#modal-done").on("shown.bs.modal", function() {
            if (!$("body").hasClass('modal-open')) {
                $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
            }
        });
    },
    
    /**
     * Ajax handle delete contract
     * 
     * @param Element el
     * @return Modal
     */
    ajaxDeleteContract: function(el) {
        var vThis = this;
        var ship_id = el.attr('data-ship');
        var contract_id = el.attr('data-contract');
        $.ajax({
            type: "POST",
            data: {"contract_id": contract_id, "ship_id": ship_id},
            url: '/ship/delete-contract',
            success: function(data) {
                vThis.hidePopup();
            },
            error: function(error) {
                vThis.errorHandler(error);
            }
         }).done(function(data) {
            if (typeof data.status != typeof undefined && data.status == true) {
                vThis.modalDone.title = data.title;
                vThis.modalDone.message = data.message;
                vThis.showPopupDoneDeleteContract();
                vThis.uiAfterDeleteContract(data);
                vThis.clearChecking("input[name='contract']");
            } else {
                vThis.modalDone.title = data.title;
                vThis.modalDone.message = data.message;
                vThis.showPopupDoneDeleteContract();
            }
        }); 
    },
    
    /**
     * Chang UI after delete contract
     * @param Response res
     * @return void
     */
    uiAfterDeleteContract: function(res) {
        if (typeof res.contracts != typeof undefined || typeof res.contractDelete != typeof undefined
                || typeof res.contractRemove != typeof undefined){
            this.reloadContract();
//            this.reloadSpot();
        }
    },
    
    reloadSpot: function() {
        $.pjax({
            url: window.location.href,
            container: '.spot-block'
        });
    },
    
    /**
     * Show popup confirm delete spot
     * @param Object data
     * @return Modal
     */
    showPopupDeleteSpot: function(data) {
        var vThis = this;
        vThis.showPopup(data);
    },
    
    /**
     * Show popup alert message after delete spot
     * @return Modal
     */
    showPopupDoneDeleteSpot: function() {
        var vThis = this;
        $('#modalTitleDone').text(vThis.modalDone.title);
        $('#modalMessageDone').text(vThis.modalDone.message);
        $("#modal-done").modal("show");
        $("#modal-done").on("shown.bs.modal", function() {
            if (!$("body").hasClass('modal-open')){
                $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
            }
        });
    },
    
    /**
     * Ajax handle delete spot
     * 
     * @param Element el
     * @returns Modal
     */
    ajaxDeleteSpot: function(el){
        var vThis = this;
        var ship_id = el.attr('data-ship');
        var spot_id = el.attr('data-spot');
        $.ajax({
            type: "POST",
            data: {"spot_id": spot_id, "ship_id": ship_id},
            url: '/ship/delete-spot',
            success: function() {
                vThis.hidePopup();
            },
            error: function(error) {
                vThis.errorHandler(error);
            }
         }).done(function(data) {
            if (typeof data.status != typeof undefined && data.status == true) {
                vThis.modalDone.title = data.title;
                vThis.modalDone.message = data.message;
                vThis.showPopupDoneDeleteSpot();
                vThis.uiAfterDeleteSpot(data);
            } else {
                vThis.modalDone.title = data.title;
                vThis.modalDone.message = data.message;
                vThis.showPopupDoneDeleteSpot();
            }
        }); 
    },
    
    /**
     * Change UI after delete spot
     * 
     * @param Response res
     * @return void
     */
    uiAfterDeleteSpot: function(res) {
        if (typeof res.spot != typeof undefined) {
            $('.approve-spot-'+res.spot).text(this.typo.apv_pending);
            this.reloadSpot();
        }
    },
    
    /**
     * Show popup display reason reject
     * 
     * @param Element
     * @returns Modal
     */
    showPopupReject: function(el) {
        var vThis = this;
        var type = el.attr('data-type');
        var id = el.attr('data-id');
        $.ajax({
            type: "GET",
            data: {"type": type, "id": id},
            url: '/ship/view-reason',
            error: function(error) {
                vThis.errorHandler(error);
            }
         }).done(function(data) {
            if (typeof data.status != typeof undefined && data.status == true) {
                $('#modalTitleDone').text(ShipModal.modalReject.title || "");
                $('#modalMessageDone').text(data.reason);
                $("#modal-done").modal("show");
                $("#modal-done").on("shown.bs.modal", function() {
                    if (!$("body").hasClass('modal-open')) {
                        $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
                    }
                });
            }
        }); 
    },
    
    /**
     * Show popup confirm delete ship
     * 
     * @param Object [Pass data into butotn btnOK]
     * @return Modal
     */
    showPopupDeleteShip: function(data) {
        var vThis = this;
        vThis.showPopup(data);
    },
    
    /**
     * Display poup done to alert success, or error.
     * @returns {undefined}
     */
    showModalAuth: function() {
        var vThis = this;
        vThis.hidePopup();
            
        $("#modal-auth").modal("show");
        $("#modal-auth").on("shown.bs.modal", function(){
            if(!$("body").hasClass('modal-open')){
                $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
            }
        });

    },
    
    /**
     * Show popup alert message after delete ship
     */
    showPopupDoneDeleteShip: function() {
        var vThis = this;
        $('#modalTitleDone').text(vThis.modalDone.title);
        $('#modalMessageDone').text(vThis.modalDone.message);
        $("#modal-done").modal("show");
        $("#modal-done").on("shown.bs.modal", function() {
            if (!$("body").hasClass('modal-open')) {
                $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
            }
        });
    },
    
    /**
     * Ajax handle delete spot
     * 
     * @param Element el
     * @return Modal
     */
    ajaxDeleteShip: function(el) {
        var vThis = this;
        if($('#pw-user').val() == ""){
            $('#ship-del-error').text(vThis.modalAuth.error_emp);
            return false;
        }

        $.ajax({
            type: "POST",
            data: {"ship_id": $('#ship-id').val(), 'pw': $('#pw-user').val()},
            url: '/ship/delete-ship',
            success: function(){
                vThis.hidePopup();
                $('#modal-auth').modal('hide');
                $('body').removeClass('modal-open').attr('style',  $('body').attr('style').replace('padding-right: 17px;', ''));
            },
            error: function(error){
                vThis.errorHandler(error);
            }
         }).done(function(data) {
             console.log(data);
            vThis.modalDone.title = data.title;
            vThis.modalDone.message = data.message || "";

            $('#modalTitleDone').text(vThis.modalDone.title);
            $('#modalMessageDone').text(vThis.modalDone.message);
            $("#modal-done").modal("show");
            $("#modal-done").on("shown.bs.modal", function() {
                if (!$("body").hasClass('modal-open')) {
                    $("body").addClass("modal-open").attr('style', $("body").attr('style')+" padding-right: 17px;");
                }
            });
            
            // Redirect after delete ship
            if (data.status) {
                setTimeout(function(e){
                    if(window.location.href.search(/company-id=[0-9]+/)) {
                        var dx = window.location.href.match(/company-id=[0-9]+/);
                    }
                    window.location.href = vThis.modalAuth.redirectAfterDone+(dx?'?'+dx[0]:'');
                }, 2000);
            }
        }); 
    },
    
    /**
     * Initial plugin after done ajax
     */
    initialPlugin: function(){
       $( ".custom-select select" ).select2({
            theme: "bootstrap",
            width: '100%',
            minimumResultsForSearch: Infinity,
            allowClear: true
        });
   }, 
   
   /**
    * Set limit page when change select box
    */
   limitPage: function() {
        var vThis = this;
        // Handle ajax for limit page
        $(document).on('change', '.limit-page', function() {
            var limit = $(this).val();
            vThis.loadPage(limit);
        });
   },
   
   /**
    * Handle refresh content load pjax after process flow
    * @param {Element.value} limit
    * @returns {void}
    */
   loadPage: function(limit) {
        var targetUrl = decodeURIComponent(window.location.protocol + "//" + window.location.host  + window.location.pathname);
        // Reset config page number and limit number for page
        var query = (window.location.search).replace(/((&?|&+|\??)page=[0-9]+)+/, '').replace(/^\?/, '');
        
        if(typeof limit !== "undefined" && !isNaN(limit) && limit > 0 ) {
            query = query.replace(/((&?|&+|\??)limit=[0-9]+)+/, '').replace(/^\?/, '');
            if (query.length) {
                query += '&limit='+limit;
            } else {
                 query += 'limit='+limit;
            }
       }
       
        // Append query to url
        targetUrl = targetUrl+'?'+query;

        $.pjax({
           url: targetUrl,
           container: '.content-load'
       });
   }
};
