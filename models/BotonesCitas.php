<?php
namespace app\models;

use app\models\Constantes;
use app\modules\ModUsuarios\models\EntUsuarios;

class BotonesCitas
{

    public $btnAutorizar =  "<a href='#'  class='btn btn-success js-aprobar'>Aprobar</a>";
    public $btnCancelar = "<a href='#'  class='btn btn-primary js-actualizar'>Actualizar</a>";
    public $btnActualizar = "<a href='#'  class='btn btn-danger js-cancelar'>Cancelar</a>";

    /**
     * Obtiene los botones Actulizar, editar y cancelar
     * @param $cita;
     * @return string 
     */
    public function getBotones($cita)
    {
        $usuario = EntUsuarios::getUsuarioLogueado();
        
        $botones = "";

        $botones .= $this->getBotonAutorizar($cita->id_status, $usuario);
        $botones .= $this->getBotonActualizar($cita->id_status,$usuario);
        $botones .= $this->getBotonCancelar($cita->id_status, $usuario);

        return $botones;
    }

    
    public function getBotonAutorizar($statusCita, $usuario)
    {
        $botonHabilitado = EntPermisosUsuarios::find()->where(["txt_auth_item"=>$usuario->txt_auth_item, "id_accion"=>Constantes::BTN_APROBAR, "id_status_cita"=>$statusCita])->one();

        if($botonHabilitado){

            return $this->btnAutorizar;
        }
        
        return "";
    }

    public function getBotonCancelar($statusCita, $usuario)
    {
        $botonHabilitado = EntPermisosUsuarios::find()->where(["txt_auth_item"=>$usuario->txt_auth_item, "id_accion"=>Constantes::BTN_RECHAZAR, "id_status_cita"=>$statusCita])->one();

        if($botonHabilitado){

            return $this->btnCancelar;
        }

        return "";
    }

    public function getBotonActualizar($statusCita, $usuario)
    {
        $botonHabilitado = EntPermisosUsuarios::find()->where(["txt_auth_item"=>$usuario->txt_auth_item, "id_accion"=>Constantes::BTN_EDITAR, "id_status_cita"=>$statusCita])->one();

        if($botonHabilitado){

            return $this->btnActualizar;
        }


        return "";
    }
 
}