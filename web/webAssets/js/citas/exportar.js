$(document).ready(function(){
    $("#form-search").on("submit", function(){
        window.onbeforeunload = null;
        swal("En proceso", "Se ha iniciado el proceso de exportación. Esta operación puede tardar dependiendo de la cantidad de información que requiere descargar", "warning");
        //$(window).off('beforeunload');
        window.history.go(-2);
    });

    $("#limpiar-busqueda").on("click", function(){
        $("form").get(0).reset();
    })
})