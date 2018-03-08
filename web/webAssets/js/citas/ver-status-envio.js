$(document).ready(function(){
    $('.magnific').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-fade',
        gallery: {
          enabled: true,
          navigateByImgClick: true,
          //preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        }
      });
});

var btnSubmit = document.getElementById("btn-upload-file");
var btnLadda = '';


function validarImagen(input){
    if(!input.val()){
        swal("Espera", "Debes agregar un archivo", "warning");
        return false;
    }else{
        return true;
    }
}

$(document).ready(function(){
    btnLadda = Ladda.create(btnSubmit);

    $(btnSubmit).on("click", function(e){
        e.preventDefault();
        btnLadda.start();

        if(validarImagen($("#input-image-upload"))){
            $('#form-upload-file').submit();
        }else{
            btnLadda.stop();
        }
        
    });

    $('#form-upload-file').on('submit',(function(e) {
        e.preventDefault();
        var token = $("#token-cita").val();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action')+"?token="+token,
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data.status=="success"){
                    $(".js-descargar-evidencia").show();
                    $(".js-descargar-evidencia").attr("href", data.result.url);
                  
                    swal("Perfecto", data.message, "success");
                    
                }else{
                    swal("Espera", data.message, "error");
                }
                btnLadda.stop();
            },
            error: function(jqXHR, textStatus, errorThrown){
                swal("Espera", "Ocurrio un problema: "+textStatus, "error");
                btnLadda.stop();
            }
        });
    }));

});