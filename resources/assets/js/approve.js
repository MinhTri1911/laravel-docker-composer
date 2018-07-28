$(function(){
    // Handle check lisst    
    Handler.initial();
    
    $(document).on("click",".btn-detail", function(e){
        var data = Handler.configDataDetail(this);
        $('#chk_ct_full').prop('checked', false).trigger('change');
        $('#chk_c_' + $(this).data('item')).prop('checked', true).trigger('change');
        Handler.loadDetail(data);
    });
    
    /**
     * Handle event when click button approve
     */
    $(document).on("click",".btn-approve", function(e){
        if (Handler.checkList.length == 0) {
            Handler.modal.title = Approve.modalCommon.title_approve || "";
            Handler.modal.message = Approve.modalCommon.message_error_require || "";
            Handler.showModalAlert();
        } else {
            // Set type of request and type of modal
            Handler.modal.type_req_approve = Handler.TYPE_REQ_APPROVE;
            Handler.modal.type = $(this).data('type');
            
            if(Handler.modal.type == Handler.TYPE_CONTRACT) {
                Handler.modal.title = Approve.modalContract.title_approve || "";
                Handler.modal.message = Approve.modalContract.message_confirm_approve || "";
            } else if (Handler.modal.type == Handler.TYPE_SPOT) {
                Handler.modal.title = Approve.modalSpot.title_approve || "";
                Handler.modal.message = Approve.modalSpot.message_confirm_approve || "";
            } else if (Handler.modal.type == Handler.TYPE_BILLING) {
                Handler.modal.title = Approve.modalBilling.title_approve || "";
                Handler.modal.message = Approve.modalBilling.message_confirm_approve || "";
            }
            
            Handler.showModalConfirm();
        }
    });
    
    /**
     * Handle event when click button reject
     */
    $(document).on("click",".btn-reject", function(e){
        if (Handler.checkList.length == 0) {
            Handler.modal.title = Approve.modalCommon.title_reject || "";
            Handler.modal.message = Approve.modalCommon.message_error_require || "";
            Handler.showModalAlert();
        } else {
            // Set type of request and type of modal
            Handler.modal.type_req_approve = Handler.TYPE_REQ_REJECT;
            Handler.modal.type = $(this).data('type');
            
            if(Handler.modal.type == Handler.TYPE_CONTRACT) {
                Handler.modal.title = Approve.modalContract.title_reject || "";
                Handler.modal.message = Approve.modalContract.message_confirm_reject || "";
            } else if (Handler.modal.type == Handler.TYPE_SPOT) {
                Handler.modal.title = Approve.modalSpot.title_reject || "";
                Handler.modal.message = Approve.modalSpot.message_confirm_approve || "";
            } else if (Handler.modal.type == Handler.TYPE_BILLING) {
                Handler.modal.title = Approve.modalBilling.title_reject || "";
                Handler.modal.message = Approve.modalBilling.message_confirm_approve || "";
            }
            
            Handler.showModalConfirm();
        }
    });
    /**
     * Handle event when click button ok on modal confirm
     */
    $(document).on("click",".btn-ok", function(e){
        if (Handler.checkList.length == 0) {
            Handler.modal.title = Approve.modalCommon.title_reject || "";
            Handler.modal.message = Approve.modalCommon.message_error_require || "";
            Handler.showModalAlert();
        } else {
            var data = {
                "id": Handler.checkList,
                "type": Handler.modal.type
            };
            
            // Check if modal approve if approve or reject
            if(Handler.modal.type_req_approve == Handler.TYPE_REQ_APPROVE) {
                Handler.handleApprove(data);
            } else if(Handler.modal.type_req_approve == Handler.TYPE_REQ_REJECT) {
                data['reason-reject'] = $('#modal-reason-reject').val();
                Handler.handleReject(data);
            } else {
                alert('Error!');
            }
        }
    });
});

var Handler = {
    // Type of request is approve
    TYPE_REQ_APPROVE : 0,
    
    // Type of request is reject 
    TYPE_REQ_REJECT: 1,
    
    // Type of modal is contract
    TYPE_CONTRACT : 0,
    
    // Type of modal is spot
    TYPE_SPOT : 1,
    
    // Type of modal is billing
    TYPE_BILLING : 2,
    
    /**
     * Initialize controls and lib need to use for script file
     * Reset lib and initial lib
     * Config pjax process
     */
    initial: function(){
        var vThis = this;
        vThis.modal.placeholder_reason = Approve.modalCommon.placeholder_reason;
        vThis.initialChecked();
        
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
            vThis.initialChecked();
        });
        
        $(document).on('pjax:popstate', function() {
            $.pjax.reload('.content-load');
        });
        
        // Handle pjax when click limit page
        vThis.limitPage();
    },
    
    /**
     * Check list
     * @type Array
     */
    checkList: [],
    
    /**
     * Config modal text display on front
     */
    modal: {
        // Type of modal is contract, spot or billing
        type: null,
        
        // Type of request approve is approve (0) or reject (1)
        type_req_approve: null,
        
        // Header default of modal
        title: "Header",
        
        // Message default of modal
        message: "This is message",
        
        placeholder_reason: ""
    },
    
    /**
     * Initialize checkbox
     * @returns void
     */
    initialChecked: function() {
        var vThis = this;
        vThis.handleCheckList("#chk_ct_full", "input[name='chk_contract']");
        vThis.handleCheckList("#chk_spt_full", "input[name='chk_spot']");
        vThis.handleCheckList("#chk_bill_full", "input[name='chk_billing']");
        vThis.autoCheck("#chk_ct_full", "input[name='chk_contract']");
        vThis.autoCheck("#chk_spt_full", "input[name='chk_spot']");
        vThis.autoCheck("#chk_bill_full", "input[name='chk_billing']");
    },
    
    /**
     * Handle checked for each item check and global check all
     * 
     * @param element elementAllCheck
     * @param element elementItemCheck
     * @return void
     */
    handleCheckList: function(elementAllCheck, elementItemCheck) {
        // Check all checkbox
        var vThis = this;
        $(document).on('change', elementAllCheck, function(e) {
           if ($(this).is(':checked')){
               $(elementItemCheck).prop('checked', true).trigger('change');
           } else {
               var checked_ch = $(elementItemCheck+":checked");
               if (checked_ch.length > 0 && vThis.checkList.length  > 0) {
                   checked_ch.each(function(index, el) {
                        var i = vThis.checkList.indexOf($(el).attr('id').replace(/[^0-9]+/, ""));
                        if(i != -1) {
                            vThis.checkList.splice(i, 1);
                        }
                   });
               } 
           
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
                var i = vThis.checkList.indexOf($(this).attr('id').replace(/[^0-9]+/, ""));
                if(i == -1) {
                    vThis.checkList.push($(this).attr('id').replace(/[^0-9]+/, ""));
                }
               
               if (checked_ch.length == $(elementItemCheck).length) {
                   $(elementAllCheck).prop('checked', true);
               }
           }
           
        });
    },
    
    /**
     * Auto checked for each item check and global check all after load pjax
     * 
     * @param element elementAllCheck
     * @param element elementItemCheck
     */
    autoCheck: function() {
        var vThis = this;
        if (vThis.checkList.length > 0) {
            for (var i = 0; i < vThis.checkList.length; i++) {
                $('#chk_c_'+vThis.checkList[i]).prop('checked', true).trigger('change');
            }
        }
    },
    
    /**
     * Display modal confirm to approve/reject
     * @returns void
     */
    showModalConfirm: function(){
        var isClick = true;
        var vThis = this;
        if($("#modal-detail").hasClass('in')){
            $("#modal-detail")
            .modal("hide")
            .on("hidden.bs.modal", function(){
                if(isClick){
                    $("#modal-confirm").find('.modal-title').text(vThis.modal.title);
                    $("#modal-confirm").find('.modal-message').text(vThis.modal.message);
                    if (vThis.modal.type_req_approve == vThis.TYPE_REQ_REJECT) {
                        $("#modal-confirm").find('.modal-message').append('<textarea class="form-control" id="modal-reason-reject" rows="4" placeholder="'+vThis.modal.placeholder_reason+'..."></textarea>');
                    }
                    $("#modal-confirm").modal("show");
                    isClick = false;
                }
            });
        }else{
            $("#modal-confirm").find('.modal-title').text(vThis.modal.title);
            $("#modal-confirm").find('.modal-message').text(vThis.modal.message);
            if (vThis.modal.type_req_approve == vThis.TYPE_REQ_REJECT) {
                $("#modal-confirm").find('.modal-message').append('<textarea class="form-control" id="modal-reason-reject" rows="4" placeholder="'+vThis.modal.placeholder_reason+'..."></textarea>');
            }
            $("#modal-confirm").modal("show");
        }
    },
    
    /**
     * Show modal detail of request approve
     * @return void
     */
    showModalService: function(){
        $('#modal-confirm').modal('hide');
        $("#modal-detail").modal("show");
    },
    
    /**
     * Show modal alert error or response from server
     * @returns void
     */
    showModalAlert: function(){
        var isClick = true;
        var vThis = this;
        
        if($("#modal-confirm").hasClass('in')){
            $("#modal-confirm")
            .modal("hide")
            .on("hidden.bs.modal", function(){
                if(isClick){
                    $("#modal-alert").find('.modal-title').text(vThis.modal.title);
                    $("#modal-alert").find('.modal-message').text(vThis.modal.message);
                    $("#modal-alert").modal("show");
                    isClick = false;
                }
            });
        }else{
            $("#modal-alert").find('.modal-title').text(vThis.modal.title);
            $("#modal-alert").find('.modal-message').text(vThis.modal.message);
            $("#modal-alert").modal("show");
        }
    },
    
    /**
     * Config type of request send to server to load detail
     * @param element el [DOM where click on]
     * @return {Handler.configDataDetail.data}
     */
    configDataDetail: function(el){
        var type = $(el).data('type');
        var data = {};
        
        if(type == this.TYPE_SPOT) {
            data = {
                id: $(el).data('item'),
                type: this.TYPE_SPOT
            };
        } else if (type == this.TYPE_BILLING) {
            data = {
                id: $(el).data('item'),
                type: this.TYPE_BILLING
            };
        } else {
            data = {
                id: $(el).data('item'),
                type: this.TYPE_CONTRACT
            };
        }
        
        return data;
    },
    
    /**
     * Load detail page of request approve
     * @param {Window.Object} data
     * @return {void}
     */
    loadDetail: function(data) {
        var vThis = this;
        $.ajax({
           type: 'GET',
           data: data,
           url: '/approve/show-detail',
           error: function(err) {
               window.location.reload();
           }
        }).done(function(res) {
            $('#modal-detail .modal-content').html(res);
            vThis.showModalService();
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
   },
   
   /**
    * Clear checked checkbox and remove item after approve/reject
    * @return {Clear checkbox}
    */
   resetAfterApprove: function() {
       var vThis = this;
       if(vThis.checkList.length > 0) {
            for (var i = 0; i < vThis.checkList.length; i++) {
                $('#item-approve-'+vThis.checkList[i]).remove();
            }
       }
       $("#chk_ct_full").prop('checked', false);
       vThis.checkList = [];
       vThis.modal.type = '';
   },
   
   /**
    * Show error when approve ocurred
    * @param {type} err
    * @returns {undefined}
    */
   handleError: function(err) {
       console.log(err);
       window.location.reload();
   },
   
   /**
    * Handle data and send request server approve
    * @param {type} data
    * @returns {undefined}
    */
   handleApprove: function(data) {
       var vThis = this;
       if (typeof data.type !== "undefined" && data.type == vThis.TYPE_CONTRACT) {
           vThis.modal.title = Approve.modalContract.title_approve || "";
       } else if (typeof data.type !== "undefined" && data.type == vThis.TYPE_SPOT) {
           vThis.modal.title = Approve.modalSpot.title_approve || "";
       } else if (typeof data.type !== "undefined" && data.type == vThis.TYPE_BILLING) {
           vThis.modal.title = Approve.modalBilling.title_approve || "";
       } else {
           vThis.modal.title = "Header default";
       }
       
       $.ajax({
           type: "POST",
           url: '/approve/accept-approve',
           data: data,
           success: function(res) {
               if(typeof res.status !== "undefined") {
                    vThis.modal.message = res.message || "";
                    vThis.showModalAlert();
                    vThis.resetAfterApprove(res);
                    vThis.loadPage();
               }
           },
           error: function(err) {
               vThis.handleError(err);
           }
       });
   },
   
   /**
    * Handle data and send request server reject
    * @param {type} data
    * @returns {undefined}
    */
   handleReject: function(data) {
       var vThis = this;
       if (typeof data.type != "undefined" && data.type == vThis.TYPE_CONTRACT) {
           vThis.modal.title = Approve.modalContract.title_reject || "";
       } else if (typeof data.type != "undefined" && data.type == vThis.TYPE_SPOT) {
           vThis.modal.title = Approve.modalSpot.title_reject || "";
       } else if (typeof data.type != "undefined" && data.type == vThis.TYPE_BILLING) {
           vThis.modal.title = Approve.modalBilling.title_reject || "";
       } else {
           vThis.modal.title = "Header default";
       }
       $.ajax({
           type: "POST",
           url: '/approve/reject-approve',
           data: data,
           success: function(res) {
               if(typeof res.status !== "undefined") {
                    vThis.modal.message = res.message || "";
                    vThis.showModalAlert();
                    vThis.resetAfterApprove(res);
                    vThis.loadPage();
               }
           },
           error: function(err) {
               vThis.handleError(err);
           }
       });
   }
};
