
  $(document).ready(function()
  {
    var uploader = $("#fileuploader").uploadFile({
    url:baseUrl+"citas/guardar-archivos",
    autoSubmit:false,
    dragdropWidth:"100%",
    statusBarWidth:"100%",
    acceptFiles:".pdf",
    fileName:"file",
    dynamicFormData: function()
    {
      var fecha = $("#fecha").val();
      var data ={ fecha:fecha}
      return data;
    }
    });

    $("#js-subir-archivos").on("click", function(){
      uploader.startUpload();
    });

  });

  
