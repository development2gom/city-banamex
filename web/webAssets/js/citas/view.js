$(document).ready(function(){
    $(".js-aprobar").on("click", function(e){
        e.preventDefault();
        var token = $(".token-cita").data("token");
        var url = baseUrl +"citas/aprobar-cita-supervisor?token="+token;
        swal({
            title: "Espera",
            text: "¿Estas seguro de aprobar esta cita?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            confirmButtonText: 'Sí, aprobar cita',
            closeButtonText: 'No',
            closeOnConfirm: false,
            //closeOnCancel: false
          },
          function() {
            window.location.href =url;
          });
    })
});