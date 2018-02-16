var inputNombre = $("#entcitas-txt_nombre");
var inputApellidoPaterno = $("#entcitas-txt_apellido_paterno");
var inputApelllidoMaterno = $("#entcitas-txt_apellido_materno");
var inputFchNacimiento = $("#entcitas-fch_nacimiento");
var inputRFC = $("#entcitas-txt_rfc");

$(document).ready(function(){

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

function colocarCamposDireccion(cat){
	$("#entcitas-txt_estado").val(cat.txt_estado);
	$("#entcitas-txt_calle_numero").val(cat.txt_calle_numero);
	$("#entcitas-txt_colonia").val(cat.txt_colonia);
	$("#entcitas-txt_codigo_postal").val(cat.txt_codigo_postal);
	$("#entcitas-txt_municipio").val(cat.txt_municipio);
}

function limpiarCamposDireccion(){
	$("#entcitas-txt_estado").val("");
	$("#entcitas-txt_calle_numero").val("");
	$("#entcitas-txt_colonia").val("");
	$("#entcitas-txt_codigo_postal").val("");
	$("#entcitas-txt_municipio").val("");
}