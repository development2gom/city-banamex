<?php
namespace app\models;

use app\models\Constantes;
use app\modules\ModUsuarios\models\EntUsuarios;

class BotonesCitas
{

    public $btnAutorizar =  "<a href='#'  class='btn btn-form-aprobar js-aprobar'>Aprobar</a>";
    public $btnActualizar = "<a href='#'  class='btn btn-form-actualizar js-actualizar'>Actualizar</a>";
    public $btnCancelar = "<a href='#'  class='btn btn-form-cancelar js-cancelar'>Cancelar</a>";

    /**
     * Obtiene los botones Actulizar, editar y cancelar
     * @param $cita;
     * @return string 
     */
    public function getBotones($cita)
    {
        $usuario = EntUsuarios::getUsuarioLogueado();
        
        $botones = "";

        $auth = Yii::$app->authManager;

        $hijos = $auth->getChildRoles($usuario->txt_auth_item);
        ksort($hijos);
        $roles = AuthItem::find()->where(['in', 'name', ])->orderBy("name")->all();

        $botones .= $this->getBotonAutorizar($cita->id_status, array_keys($hijos));
        $botones .= $this->getBotonActualizar($cita->id_status,array_keys($hijos));
        $botones .= $this->getBotonCancelar($cita->id_status, array_keys($hijos));

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