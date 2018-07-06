$(function(){
    // Handle check lisst    
    Handler.initial();
    
    // Handle restore    
    $(document).on("click",".restore-contract", function(){
        var service = $(this).data('service');
        var data = {
            'ship': $(this).data('ship'),
            'contract': $(this).data('contract')
        };
        
        Handler.typeModal = "restore";
        Handler.modalPopup.title = "契約を復活確認";
        Handler.modalPopup.message = service+"の契約を復活してもよろしいですか?";
        Handler.showPopup(data);
    });
     
    /**
     * 
     */
    $(document).on("click",".disable-contract", function(){
        var idContracts = '';
        
        if(Handler.checkList.length > 0){
            Handler.checkList.forEach(function(value){
                idContracts += value+':';
            });
            
            var data = {
                'ship': $(this).data('ship'),
                'contract': idContracts.substr(0, idContracts.lastIndexOf(":"))
            };

            Handler.typeModal = "disable";
            Handler.modalPopup.title = "契約を無効確認";
            Handler.modalPopup.message = "契約を無効にしてもよろしいですか?";
            Handler.showPopup(data);
        }else{
            Handler.isOnlyPoupDone =  true;
            Handler.typeModal = "";
            Handler.modalDone.title = "Lỗi";
            Handler.modalDone.message = "Vui lòng chọn một hợp đồng";
            Handler.showPopupDone();
        }
    });
    
    // Delete contract
    $(document).on("click",".delete-contract", function(){
        var idContracts = '';
        
        if(Handler.checkList.length > 0){
            Handler.checkList.forEach(function(value){
                idContracts += value+':';
            });

            var data = {
                'ship': $(this).data('ship'),
                'contract': idContracts.substr(0, idContracts.lastIndexOf(":"))
            };

            Handler.typeModal = "delete";
            Handler.modalPopup.title = "契約を削除確認";
            Handler.modalPopup.message = "選択した契約を削除してもよろしいですか?";
            Handler.showPopup(data);
        }else{
            Handler.isOnlyPoupDone =  true;
            Handler.typeModal = "";
            Handler.modalDone.title = "Lỗi";
            Handler.modalDone.message = "Vui lòng chọn một hợp đồng";
            Handler.showPopupDone();
        }
    });
    
    // Handle restore    
    $(document).on("click",".delete-spot", function(){
        var data = {
            'ship': $(this).data('ship'),
            'spot': $(this).data('spot')
        };
        
        Handler.typeModal = "delete-spot";
        Handler.modalPopup.title = "スポット費用を削除確認";
        Handler.modalPopup.message = $(this).data('spot')+"を削除してもよろしいですか?";
        Handler.showPopup(data);
    });
    
    // Handle button click OK inside modal
    $(document).on('click', '#modalBtnOK', function(e){
        Handler.modalPopup.isClickOk = true;
        if(Handler.typeModal != "" && Handler.typeModal == "restore"){
            Handler.ajaxRestoreContract($(this));
        }else if(Handler.typeModal != "" && Handler.typeModal == "disable"){
            Handler.ajaxDisableContract($(this));
        }else if(Handler.typeModal != "" && Handler.typeModal == "delete"){
            Handler.ajaxDeleteContract($(this));
        }else if(Handler.typeModal != "" && Handler.typeModal == "delete-spot"){
            Handler.ajaxDeleteSpot($(this));
        }
    });
});

/**
 * Object handler processing funtion or follow processing
 * 
 * @type type
 */
var Handler = {
    /**
     * 
     * @returns {undefined}
     */
    initial: function(){
        this.handleCheckList("#chk_ct_full", "input[name='contract']");
        // Remove attribute after append to
        $("#modal-confirm").on('hide.bs.modal', function(){
            $("#modal-confirm").find('#modalBtnOK').removeAttr('data-ship data-contract');
        });
    },
    
    /**
     * 
     * @type String
     */
    typeModal: '',
    
    /**
     * Text status message
     * @type type
     */
    typo: {
        stt_active: "Đang hoạt động",
        stt_pending: "Đang tạm dừng",
        stt_finish: "Đã ngừng hoạt động",
        
        apv_done: "Đã approve",
        apv_pending: "Đang chờ approve",
        apv_reject: "Đã từ chối",
    },
    
    /**
     * 
     * @type type
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
        title: "Ttitle done",
        message: "Message done"
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
     * @param {type} elementAllCheck
     * @param {type} elementItemCheck
     * @returns {undefined}
     */
    handleCheckList: function(elementAllCheck, elementItemCheck){
        // Check all checkbox
        var vThis = this;
        $(document).on('change', elementAllCheck, function(e){
           if($(this).is(':checked')){
               $(elementItemCheck).prop('checked', true).trigger('change');
           }else{
               vThis.checkList = [];
               $(elementItemCheck).prop('checked', false);
           }
        });
        
        // When check item with status checked and check all
        $(elementItemCheck).on('change', function(e){
           if(!$(this).is(':checked')){
               $(elementAllCheck).prop('checked', false);
               if(vThis.checkList.length > 0){
                   var i = vThis.checkList.indexOf($(this).attr('id').replace(/[^0-9]+/, ""));
                    if(i != -1) {
                        vThis.checkList.splice(i, 1);
                    }
               }
           }else{
               var checked_ch = $(elementItemCheck+":checked");
               vThis.checkList.push($(this).attr('id').replace(/[^0-9]+/, ""));
               if(checked_ch.length == $(elementItemCheck).length){
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
    itemChecking: function(el){
        var els = [];
        if(el != null && typeof el != typeof undefined){
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
    clearChecking: function(elementItemCheck){
        $(elementItemCheck).prop('checked', false).trigger('change');
    },
    
    /**
     * Show popup confirm restore
     * 
     * @param {type} data
     * @returns {undefined}
     */
    showPopup: function(data){
        $('#modalTitle').text(this.modalPopup.title);
        $('#modalMessage').text(this.modalPopup.message);
        $("#modal-confirm").modal("show");
        
        // Set data for btn ok
        if(typeof data != typeof undefined){
            for(var key in data){
                $("#modal-confirm").find('#modalBtnOK').attr('data-'+key, data[key]);
            }
        }
    },
    
    /**
     * Hide popup confirm
     * @returns {undefined}
     */
    hidePopup: function(){
        $("#modal-confirm").modal("hide");
    },
    
    /**
     * Display poup done to alert success, or error.
     * @returns {undefined}
     */
    showPopupDone: function(){
        this.hidePopup();
        var vThis = this;
        if(!this.isOnlyPoupDone){
            $("#modal-confirm").on('hidden.bs.modal', function(){
                if(vThis.modalPopup.isClickOk && vThis.modalPopup.afterShowPopup){
                   $('#modalTitleDone').text(vThis.modalDone.title);
                   $('#modalMessageDone').text(vThis.modalDone.message);
                   $("#modal-done").modal("show");
                   vThis.modalPopup.isClickOk = false;
                }
            });
        }else{
            $('#modalTitleDone').text(vThis.modalDone.title);
            $('#modalMessageDone').text(vThis.modalDone.message);
            $("#modal-done").modal("show");
            vThis.modalPopup.isClickOk = false;
            vThis.isOnlyPoupDone = false;
        }
    },
    
    /**
     * Function handle error exception
     * 
     * @param {type} error
     * @returns {undefined}
     */
    errorHandler: function(error){
        
    },
    
    /**
     * Ajax handle restore contracts
     * 
     * @param {type} el
     * @returns {undefined}
     */
    ajaxRestoreContract: function(el){
        var vThis = this;
        var ship_id = el.attr('data-ship');
        var contract_id = el.attr('data-contract');
        $.ajax({
            type: "POST",
            data: {"contract_id": contract_id, "ship_id": ship_id},
            url: '/ship/contract/restore-contract',
            success: function(data){
                vThis.hidePopup();
            },
            error: function(error){
                vThis.errorHandler(error);
            }
         }).done(function(data){
             if(typeof data.redirectTo != typeof undefined){
                 vThis.modalPopup.afterShowPopup = false;
                 vThis.location.href = data.redirectTo;
             }else{
                 if(typeof data.status != typeof undefined && data.status == true){
                     vThis.modalDone.title = "Thanhf coong";
                     vThis.modalDone.message = "Xoas thanhf coong";
                     vThis.modalPopup.afterShowPopup = true;
                     vThis.showPopupDone();
                     vThis.uiAfterRestoreContract(data);
                     vThis.clearChecking("input[name='contract']");
                 }else{
                     vThis.modalDone.title = "That bai";
                     vThis.modalDone.message = "Xoas that bai";
                     vThis.modalPopup.afterShowPopup = true;
                     vThis.showPopupDone();
                 }
             }
         }); 
    },
    
    /**
     * 
     * @param {type} res
     * @returns {undefined}
     */
    uiAfterRestoreContract: function(res){
        $('.restore-contract-'+res.contract).remove();
        $('.status-contract-'+res.contract).text(this.typo.stt_active);
        $('.approve-contract-'+res.contract).text(this.typo.apv_pending);
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
            url: '/ship/contract/disable-contract',
            success: function(data){
                vThis.hidePopup();
            },
            error: function(error){
                vThis.errorHandler(error);
            }
         }).done(function(data){
            if(typeof data.status != typeof undefined && data.status == true){
                vThis.modalDone.title = "Thanhf coong";
                vThis.modalDone.message = "disable thanhf coong cac hop dong "+ data.contracts;
                vThis.modalPopup.afterShowPopup = true;
                vThis.showPopupDone();
                vThis.uiAfterDisableContract(data);
                vThis.clearChecking("input[name='contract']");
            }else{
                vThis.modalDone.title = "That bai";
                vThis.modalDone.message = "disable that bai";
                vThis.modalPopup.afterShowPopup = true;
                vThis.showPopupDone();
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
            console.log(res.contracts);
            for(var i = 0; i < res.contracts.length; i++){
                $('.status-contract-'+res.contracts[i]).text(this.typo.stt_pending);
                $('.approve-contract-'+res.contracts[i]).text(this.typo.apv_pending);
            }
        }
    },
    
    /**
     * Ajax handle delete contract
     * 
     * @param {type} el
     * @returns {undefined}
     */
    ajaxDeleteContract: function(el){
        var vThis = this;
        var ship_id = el.attr('data-ship');
        var contract_id = el.attr('data-contract');
        $.ajax({
            type: "POST",
            data: {"contract_id": contract_id, "ship_id": ship_id},
            url: '/ship/contract/delete-contract',
            success: function(data){
                vThis.hidePopup();
            },
            error: function(error){
                vThis.errorHandler(error);
            }
         }).done(function(data){
            if(typeof data.status != typeof undefined && data.status == true){
                vThis.modalDone.title = "Thanhf coong";
                vThis.modalDone.message = "Xoa thanhf coong cac hop dong "+ data.contracts;
                vThis.modalPopup.afterShowPopup = true;
                vThis.showPopupDone();
                vThis.uiAfterDeleteContract(data);
                vThis.clearChecking("input[name='contract']");
            }else{
                vThis.modalDone.title = "That bai";
                vThis.modalDone.message = "xoas that bai";
                vThis.modalPopup.afterShowPopup = true;
                vThis.showPopupDone();
            }
        }); 
    },
    
    /**
     * 
     * @param {type} res
     * @returns {undefined}
     */
    uiAfterDeleteContract: function(res){
        if(typeof res.contracts != typeof undefined){
            for(var i = 0; i < res.contracts.length; i++){
                $('.status-contract-'+res.contracts[i]).text(this.typo.stt_finish);
                $('.approve-contract-'+res.contracts[i]).text(this.typo.apv_pending);
            }
        }
    },
    
    /**
     * Ajax handle delete spot
     * 
     * @param {type} el
     * @returns {undefined}
     */
    ajaxDeleteSpot: function(el){
        var vThis = this;
        var ship_id = el.attr('data-ship');
        var spot_id = el.attr('data-spot');
        $.ajax({
            type: "POST",
            data: {"spot_id": spot_id, "ship_id": ship_id},
            url: '/ship/contract/delete-spot',
            success: function(data){
                vThis.hidePopup();
            },
            error: function(error){
                vThis.errorHandler(error);
            }
         }).done(function(data){
            if(typeof data.status != typeof undefined && data.status == true){
                vThis.modalDone.title = "Thanhf coong";
                vThis.modalDone.message = "Xoa thanhf coong spot "+ data.spot;
                vThis.modalPopup.afterShowPopup = true;
                vThis.showPopupDone();
                vThis.uiAfterDeleteSpot(data);
            }else{
                vThis.modalDone.title = "That bai";
                vThis.modalDone.message = "xoas that bai";
                vThis.modalPopup.afterShowPopup = true;
                vThis.showPopupDone();
            }
        }); 
    },
    
    /**
     * 
     * @param {type} res
     * @returns {undefined}
     */
    uiAfterDeleteSpot: function(res){
        if(typeof res.spot != typeof undefined){
            $('.approve-spot-'+res.spot).text(this.typo.apv_pending);
        }
    },
}



