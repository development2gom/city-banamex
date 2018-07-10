$(document).ready(function(){
    

    $(".limpiar-busqueda").on("click", function(){
        $(this).parents("form").get(0).reset();
        
    })
})