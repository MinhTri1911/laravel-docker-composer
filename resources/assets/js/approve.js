$(function(){
	$(document).on("click",".btn-detail", function(e){
        $("#modal-service").modal("show")}
    );
    $(document).on("click",".btn-approve, .btn-reject", function(e){
        var isClick = true;
        if($("#modal-service").hasClass('in')){
            $("#modal-service")
            .modal("hide")
            .on("hidden.bs.modal", function(){
                if(isClick){
                    $("#modal-confirm").modal("show");
                    isClick = false;
                }
            });
        }else{
             $("#modal-confirm").modal("show");
        }
    });
});