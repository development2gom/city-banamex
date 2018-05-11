var inputNombre = $("#entcitas-txt_nombre");
var inputApellidoPaterno = $("#entcitas-txt_apellido_paterno");
var inputApelllidoMaterno = $("#entcitas-txt_apellido_materno");
var inputFchNacimiento = $("#entcitas-fch_nacimiento");
var inputRFC = $("#entcitas-txt_rfc");

$(document).ready(function(){

	$("input:not(#entcitas-txt_email)").on("change", function(){
		
		$(this).val($(this).val().toUpperCase());
	});

	buscarMunicipioCodigo($("#entcitas-txt_codigo_postal").val());
	$("#entcitas-txt_codigo_postal").on("change", function(){
		var elemento = $(this);
		var token = elemento.val();
		if(token!=""){
			buscarMunicipioCodigo(token);
		}else{
			$("#entcitas-id_area").val("");
			$("#txt_area").val("");

			$("#entcitas-num_dias_servicio").val("");
			$("#num_dias_servicio").val("");

			$("#entcitas-txt_municipio").val("");

		}
	
		
	});

    inputNombre.on("change", function(){
        calculaRFC();
    });

    inputApellidoPaterno.on("change", function(){
        calculaRFC();
    });

    inputApelllidoMaterno.on("change", function(){
        calculaRFC();
    });

    inputFchNacimiento.on("change", function(){
        calculaRFC();
	});
	

});

function buscarMunicipioCodigo(token){
//03100
$.ajax({
	url:baseUrl+"rel-municipio-codigo-postal/buscar-municipio-cp?cp="+token,
	success:function(r){
		if(r.status=="success"){
			$("#entcitas-id_area").val(r.result.id_area);
			$("#txt_area").val(r.result.txt_area);

			$("#entcitas-num_dias_servicio").val(r.result.num_dias_servicios);
			$("#num_dias_servicio").val(r.result.text_dias_servicios);

			$("#entcitas-txt_municipio").val(r.result.txt_municipio);

			$("#entcitas-fch_cita").kvDatepicker('destroy');
			$("#entcitas-fch_cita").kvDatepicker({
				"clearBtn": true,
				"autoclose":true,
				"format":"dd-mm-yyyy",
				"language":"es",
				'daysOfWeekDisabled':r.result.num_dias_servicios,
				'startDate' : r.result.fch_inicio, //date("d-m-Y")
                    'endDate':r.result.fch_final
			});

			$("#entcitas-fch_cita").trigger("change");
			
		}
	},
	error:function(){
		
	}
});
}

function calculaRFC() {
	function quitaArticulos(palabra) {
		return palabra.replace("DEL ", "").replace("LAS ", "").replace("DE ",
				"").replace("LA ", "").replace("Y ", "").replace("A ", "");
	}
	function esVocal(letra) {
		if (letra == 'A' || letra == 'E' || letra == 'I' || letra == 'O'
				|| letra == 'U' || letra == 'a' || letra == 'e' || letra == 'i'
				|| letra == 'o' || letra == 'u')
			return true;
		else
			return false;
	}
	nombre = inputNombre.val().toUpperCase();
	apellidoPaterno = inputApellidoPaterno.val().toUpperCase();
	apellidoMaterno = inputApelllidoMaterno.val().toUpperCase();
	fecha = inputFchNacimiento.val();
	var rfc = "";
	apellidoPaterno = quitaArticulos(apellidoPaterno);
	apellidoMaterno = quitaArticulos(apellidoMaterno);
	rfc += apellidoPaterno.substr(0, 1);
	var l = apellidoPaterno.length;
	var c;
	for (i = 0; i < l; i++) {
		c = apellidoPaterno.charAt(i);
		if (esVocal(c) && i>0) {
			rfc += c;
			break;
		}
	}
	rfc += apellidoMaterno.substr(0, 1);
	rfc += nombre.substr(0, 1);
	rfc += fecha.substr(8, 10);
	rfc += fecha.substr(3, 5).substr(0, 2);
	rfc += fecha.substr(0, 2);
	// rfc += "-" + homclave;
	inputRFC.val(rfc);
}

function deshabilitarCamposDireccion(){
	habilitarDeshabilitarCampos(false);
}

function habilitarCamposDireccion(){
	habilitarDeshabilitarCampos(true);
}

function habilitarDeshabilitarCampos(isHabilitado){
	$("#entcitas-txt_estado").attr("disabled", isHabilitado);
	$("#entcitas-txt_calle_numero").attr("disabled", isHabilitado);
	$("#entcitas-txt_colonia").attr("disabled", isHabilitado);
	$("#entcitas-txt_codigo_postal").attr("disabled", isHabilitado);
	$("#entcitas-txt_municipio").attr("disabled", isHabilitado);
}

function colocarCamposDireccionPredeterminados(){
	colocarCampos(estado, calleYNumbero, colonia, codigoPostal,municipio,  entreCalles, pReferencias);
}

function colocarCamposDireccion(cat){
	if(cat.txt_estado){
		colocarCampos(cat.txt_estado, cat.txt_calle_numero, cat.txt_colonia, cat.txt_codigo_postal, cat.txt_municipio, "", "");
	}else{
		colocarCamposDireccionPredeterminados();
	}
	
}

function colocarCampos(estadoP, calleYNumeroP, coloniaP, cPP, municipioP, entreCallesP, observacionesP){
	$("#entcitas-txt_estado").val(estadoP);
	$("#entcitas-txt_calle_numero").val(calleYNumeroP);
	$("#entcitas-txt_colonia").val(coloniaP);
	
	$("#entcitas-txt_codigo_postal").val(cPP);
	$("#entcitas-txt_municipio").val(municipioP);
	$("#entcitas-txt_entre_calles").val(entreCallesP);
	$("#entcitas-txt_observaciones_punto_referencia").val(observacionesP);
}

function limpiarCamposDireccion(){
	colocarCampos("","","","","", "", "");
}