<?php
namespace app\models;
class Constantes{
    const STATUS_CREADA = 1;
    const STATUS_AUTORIZADA_POR_SUPERVISOR = 2;
    const STATUS_AUTORIZADA_POR_SUPERVISOR_TELCEL = 3;
    const STATUS_AUTORIZADA_POR_ADMINISTRADOR_CC = 4;
    const STATUS_CANCELADA_SUPERVISOR_CC = 5;
    const STATUS_CANCELADA_SUPERVISOR_TELCEL = 11;
    const STATUS_CANCELADA_ADMINISTRADOR_CC = 12;
    const STATUS_CANCELADA_ADMINISTRADOR_TELCEL = 13;
    const STATUS_AUTORIZADA_POR_ADMINISTRADOR_TELCEL = 7;

    //TIPOS DE USUARIOS
    const USURIO_ADMIN = "admin";
    const USUARIO_CALL_CENTER = "call-center";
    const USUARIO_SUPERVISOR = "supervisor-call-center";
    const USUARIO_SUPERVISOR_TELCEL = "supervisor-tel";
    const USUARIO_ADMINISTRADOR_TELCEL = "administrador-tel";
    const USUARIO_ADMINISTRADOR_CC = "administrador-call-center";

    // Colores status
    const COLOR_STATUS_CREADA = "warning";
    const COLOR_STATUS_AUTORIZADA_POR_SUPERVISOR = "green-light";
    const COLOR_STATUS_AUTORIZADA_POR_SUPERVISOR_TELCEL = "green-medium";
    const COLOR_STATUS_RECHAZADA = "danger";
    const COLOR_STATUS_CANCELADA = "danger";
    const COLOR_STATUS_AUTORIZADA_POR_ADMINISTRADOR_TELCEL = "green";

    // Tiempo que se puede editar una cita
    const TIEMPO_EDICION = 2;

    // Identificador del cliente
    const IDENTIFICADOR_CLIENTE = "BSMH-";

    // Sin equipo
    const SIN_EQUIPO = 1;

    // tipos de errors
    const CALL_CENTER = "call-center";
    const TELCEL = "telcel";

    // tipos de usuarios excel
    const USUARIO_EXCEL_ADMINISTRADOR = "Administrador";
    const USUARIO_EXCEL_SUPERVISOR = "Supervisor";
    const USUARIO_EXCEL_CALL_CENTER = "Usuario call center";

    // botones acciones de cita
    const BTN_APROBAR = 2;
    const BTN_EDITAR = 3;
    const BTN_RECHAZAR = 4;
}