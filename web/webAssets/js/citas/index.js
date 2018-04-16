$(document).ready(function(){
    $("#pjax-usuarios").on('pjax:complete', function() {
        $("#entcitassearch-fch_creacion").kvDatepicker({"clearBtn": true,"autoclose":true,"format":"dd-mm-yyyy","language":"es"});
        $("#entcitassearch-fch_cita").kvDatepicker({"clearBtn": true,"autoclose":true,"format":"dd-mm-yyyy","language":"es"});
        
      })
});

$(document).on({
    'click': function(){
        mostrarLoading();
    }
}, ".js-search-button");

$(document).on({
    'click': function(){
        mostrarLoading();
    }
}, ".animsition-linke");

$(document).on({
    'click': function(){
        clearInput($(this));
    }
}, ".js-clear-input");

$(document).on({
    'click': function(){
        resetForm($("#form-search").get(0));
        $('#entcitassearch-id_status').val(null).trigger("change");
    }
}, ".js-limpiar-campos");

$(document).on({
    'click': function(){
        if($(".js-search-button").val()==1){
            $(".js-search-button").val(0);
        }else{
            $(".js-search-button").val(1);
        }
    }
}, ".js-collapse");

$(document).on({
    'click': function(){
        mostrarLoading();
    }
}, "table thead a, a.list-group-item");


function mostrarLoading(){
    $("#panel .panel-body").addClass("fade-out");
    $(".js-ms-loading").addClass("fade-in");
}

function clearInput(elemento){
    var padre = elemento.parents(".form-group");
    var input = padre.find(".form-control");
    input.val("");
    
}

$(".list-group-item-tag").on("click", function(e){
    
    $('.list-group-item-tag').removeClass("active");
    $(this).toggleClass('active');
});

$(document).ready(function(){

    $("#pjax-usuarios").on('pjax:complete', function() {
        $("#entcitassearch-fch_creacion").kvDatepicker({"clearBtn": true,"autoclose":true,"format":"dd-mm-yyyy","language":"es"});
        $("#entcitassearch-fch_cita").kvDatepicker({"clearBtn": true,"autoclose":true,"format":"dd-mm-yyyy","language":"es"});
        actualizarEnvios();
      })

      actualizarEnvios();
    
});

function actualizarEnvios(){
// The .each() method is unnecessary here:
$( ".actualizar-envio" ).each(function() {
    var elemento = $(this);
    var envio = elemento.data("envio");
    $.ajax({
        url: baseUrl+"citas/actualizar-envio?envio="+envio,
        success:function(r){
            if(r.status="success"){
                $("#js-cita-envio-"+r.result.token).replaceWith(r.result.a);
            }
        },
        error:function(x, y, z){
            
        }   
    });
});
}