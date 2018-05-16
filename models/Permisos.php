<?php
namespace app\models;

use Yii;
use app\models\EntCitasSearch;
use app\models\Constantes;
use app\modules\ModUsuarios\models\EntUsuarios;

class Permisos
{

    public static function getUsuarios($query){
        $usuario = Yii::$app->user->identity;

        switch ($usuario->txt_auth_item) {
            case Constantes::USUARIO_CALL_CENTER:
                
                break;
            case Constantes::USUARIO_SUPERVISOR:
                
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                $query->andFilterWhere(['id_call_center'=>$usuario->id_call_center]);
                $query->andFilterWhere(['!=', 'id_usuario', $usuario->id_usuario]);
                # code...
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
            
                # code...
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                # code...
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                $query->andFilterWhere(['id_call_center'=>$usuario->id_call_center]);
                $query->andFilterWhere(['!=', 'id_usuario', $usuario->id_usuario]);
                # code...
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                # code...
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                # code...
                break;

        }

        return $query;
    }

    public static function getCitasByRole($query)
    {
        $usuario = Yii::$app->user->identity;

        switch ($usuario->txt_auth_item) {
            case Constantes::USUARIO_CALL_CENTER:
                // Usuario solo puede ver sus citas creadas
                $query->andFilterWhere(['id_usuario' => $usuario->id_usuario, 'id_call_center'=>$usuario->id_call_center]); 
                break;
            case Constantes::USUARIO_SUPERVISOR:
                // usuario puede ver todo su equipo de trabajo
                $misUsuarios = $usuario->entGruposTrabajos;
                
                $usuarioAsignado = [];
                $usuarioAsignado[] = $usuario->id_usuario;
                foreach($misUsuarios as $miUsuario){
                    $usuarioAsignado[] = $miUsuario->id_usuario_asignado;
                }

                $query->andFilterWhere(['in','id_usuario', $usuarioAsignado])->andFilterWhere(['id_call_center'=>$usuario->id_call_center]);
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                $query->andFilterWhere(['id_call_center'=>$usuario->id_call_center]);
                # code...
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
                # code...
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                # code...
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                # code...
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                # code...
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                # code...
                break;

        }

        return $query;
    }

    public static function canUsuarioVerStatusEnvio(){
        $usuario = EntUsuarios::getUsuarioLogueado();
        $canUser = true;
        switch ($usuario->txt_auth_item) {
            case Constantes::USUARIO_CALL_CENTER:
                $canUser = false;
                break;
            case Constantes::USUARIO_SUPERVISOR:
                $canUser = false;
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                $canUser = true;
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
                $canUser = false;
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                $canUser = true;
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                $canUser = true;
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                $canUser = true;
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                $canUser = true;
                break;
            default:
                $canUser = null;
            break;
        }

        return $canUser;

    }

    public static function getStatusAprobacionDependiendoUsuario(){
        $usuario = EntUsuarios::getUsuarioLogueado();
        switch ($usuario->txt_auth_item) {
            case Constantes::USUARIO_CALL_CENTER:
                $idStatus = Constantes::STATUS_CREADA;
                break;
            case Constantes::USUARIO_SUPERVISOR:
                $idStatus = Constantes::STATUS_AUTORIZADA_POR_SUPERVISOR;
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                $idStatus = Constantes::STATUS_AUTORIZADA_POR_ADMINISTRADOR_CC;
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
                $idStatus = Constantes::STATUS_AUTORIZADA_POR_SUPERVISOR_TELCEL;
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                $idStatus = Constantes::STATUS_AUTORIZADA_POR_ADMINISTRADOR_TELCEL;
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                $idStatus = Constantes::STATUS_AUTORIZADA_POR_MASTER_BRIGHT_STAR;
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                $idStatus= Constantes::STATUS_AUTORIZADA_POR_MASTER_CALL_CENTER;
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                $idStatus = Constantes::STATUS_AUTORIZADA_POR_MASTER_TELCEL;
                break;
            default:
                $idStatus = null;
            break;
        }

        return $idStatus;
    }

    public static function getStatusRechazarDependiendoUsuario(){

        $usuario = EntUsuarios::getUsuarioLogueado();
        switch ($usuario->txt_auth_item) {
            
            case Constantes::USUARIO_SUPERVISOR:
                $idStatus = Constantes::STATUS_RECHAZO_SUPERVISOR_CC;
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                $idStatus = Constantes::STATUS_RECHAZO_ADMINISTRADOR_CC;
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
                $idStatus = Constantes::STATUS_RECHAZO_SUPERVISOR_TELCEL;
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                $idStatus = Constantes::STATUS_RECHAZO_ADMINISTRADOR_TELCEL;
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                $idStatus = Constantes::STATUS_RECHAZO_POR_MASTER_BRIGHT_STAR;
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                $idStatus = Constantes::STATUS_RECHAZO_POR_MASTER_CALL_CENTER;
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                $idStatus = Constantes::STATUS_RECHAZO_POR_MASTER_TELCEL;
                break;
            default:
                $idStatus = null;
            break;
        
        }
        return $idStatus;
    }

    public static function getStatusCancelacionesDependiendoUsuario(){

        $usuario = EntUsuarios::getUsuarioLogueado();
        switch ($usuario->txt_auth_item) {
            
            case Constantes::USUARIO_SUPERVISOR:
                $idStatus = Constantes::STATUS_CANCELADA_SUPERVISOR_CC;
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                $idStatus = Constantes::STATUS_CANCELADA_ADMINISTRADOR_CC;
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
                $idStatus = Constantes::STATUS_CANCELADA_SUPERVISOR_TELCEL;
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                $idStatus = Constantes::STATUS_CANCELADA_ADMINISTRADOR_TELCEL;
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                $idStatus = Constantes::STATUS_CANCELADA_POR_MASTER_BRIGHT_STAR;
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                $idStatus = Constantes::STATUS_CANCELADAS_POR_MASTER_CALL_CENTER;
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                $idStatus = Constantes::STATUS_CANCELADA_POR_MASTER_TELCEL;
                break;
            default:
                $idStatus = null;
            break;
        
        }
        return $idStatus;
    }

    

    public static function getMessageHistorialGuardar(){
        $usuario = EntUsuarios::getUsuarioLogueado();

        switch ($usuario->txt_auth_item) {
            case Constantes::USUARIO_CALL_CENTER:
                return "Cita creada";
                break;
            case Constantes::USUARIO_SUPERVISOR:
                return "Cita capturada y autorizada por supervisor cc";
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                return "Cita capturada y autorizada por administrador cc";
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
                return "Cita capturada y autorizada por supervisor telcel";
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                return "Cita capturada y autorizada por administador telcel";
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                return "Cita capturada y autorizada por master bright star";
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                return "Cita capturada y autorizada por master cc";
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                return "Cita capturada y autorizada por master telcel";
                break;
            default:
                return "";
            break;
        }
    }

    public static function getMessageHistorialAprobar(){
        $usuario = EntUsuarios::getUsuarioLogueado();

        switch ($usuario->txt_auth_item) {
            case Constantes::USUARIO_CALL_CENTER:
                return "";
                break;
            case Constantes::USUARIO_SUPERVISOR:
                return "Cita cancelada por supervisor cc";
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                return "Cita cancelada por administrador cc";
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
                return "Cita cancelada por supervisor telcel";
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                return "Cita cancelada por administador telcel";
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                return "Cita cancelada por master bright star";
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                return "Cita cancelada por master cc";
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                return "Cita cancelada por master telcel";
                break;
            default:
                return "";
            break;
        }
    }

    public static function getMessageHistorialRechazar(){
        $usuario = EntUsuarios::getUsuarioLogueado();

        switch ($usuario->txt_auth_item) {
            case Constantes::USUARIO_CALL_CENTER:
                return "";
                break;
            case Constantes::USUARIO_SUPERVISOR:
                return "Cita rechazada por supervisor cc";
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                return "Cita rechazada por administrador cc";
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
                return "Cita rechazada por supervisor telcel";
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                return "Cita rechazada por administador telcel";
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                return "Cita rechazada por master bright star";
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                return "Cita rechazada por master cc";
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                return "Cita rechazada por master telcel";
                break;
            default:
                return "";
            break;
        }
    }

    public static function getMessageHistorialCancelar(){
        $usuario = EntUsuarios::getUsuarioLogueado();

        switch ($usuario->txt_auth_item) {
            case Constantes::USUARIO_CALL_CENTER:
                return "";
                break;
            case Constantes::USUARIO_SUPERVISOR:
                return "Cita cancelada por supervisor cc";
                break;
            case Constantes::USUARIO_ADMINISTRADOR_CC:
                return "Cita cancelada por administrador cc";
                break;
            case Constantes::USUARIO_SUPERVISOR_TELCEL:
                return "Cita cancelada por supervisor telcel";
                break;
            case Constantes::USUARIO_ADMINISTRADOR_TELCEL:
                return "Cita cancelada por administador telcel";
                break;
            case Constantes::USUARIO_MASTER_BRIGHT_STAR:
                return "Cita cancelada por master bright star";
                break;
            case Constantes::USUARIO_MASTER_CALL_CENTER:
                return "Cita cancelada por master cc";
                break;
            case Constantes::USUARIO_MASTER_TELCEL:
                return "Cita cancelada por master telcel";
                break;
            default:
                return "";
            break;
        }
    }
}