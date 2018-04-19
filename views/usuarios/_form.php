<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\View;
use app\models\Constantes;
use app\modules\ModUsuarios\models\EntUsuarios;

?>
<div class="row">
    <div class="col-md-4">
        <div class="user-file">
            <a class="user-file-a js-img-avatar">
                <img class="js-image-preview" src="<?= Url::base() . "/webAssets/images/site/user.png" ?>">
            </a>
        </div>
    </div>
    <div class="col-md-8">

        <?php $form = ActiveForm::begin([
            'id' => 'form-guardar-usuario',
                    //'options' => ['class' => 'form-horizontal'],
                    //'enableAjaxValidation' => true,
            'enableClientValidation' => true,
        ]); ?>

            <?= $form->field($model, 'image')->fileInput(["class" => "hidden-xxl-down"])->label(false) ?> 
            <h4>Datos Generales</h4>
            <div class="row">
                <div class="col-md-6">

                    <?= $form->field($model, 'txt_auth_item')
                        ->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($roles, 'name', 'description'),
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccionar tipo de usuario'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                    ?> 
                </div>
                <?php
                $usuarioCallCenter = Constantes::USUARIO_CALL_CENTER;
                $usuarioSupervisor = Constantes::USUARIO_SUPERVISOR;
                $usuarioAdministrador = Constantes::USUARIO_ADMINISTRADOR_CC;
                $usuarioMaster = Constantes::USUARIO_MASTER_CALL_CENTER;
                $isCallCenter = false;
                if($model->txt_auth_item==$usuarioCallCenter 
                || $model->txt_auth_item == $usuarioSupervisor 
                || $model->txt_auth_item==$usuarioAdministrador
                || $model->txt_auth_item==$usuarioMaster){
                    $isCallCenter = true;
                }

                $usuario = EntUsuarios::getIdentity();
                if(!($usuario->txt_auth_item==Constantes::USUARIO_ADMINISTRADOR_CC || $usuario->txt_auth_item==Constantes::USUARIO_MASTER_CALL_CENTER)){
                ?>
                <div class="col-md-6 contenedor-call-center" style="display:<?=$isCallCenter?'display':'none'?>;">
                     <?= $form->field($model, 'id_call_center')
                        ->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($callCenters, 'id_call_center', 'txt_nombre'),
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccionar call center'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                    ?> 

                </div>

                <?php
                }
                ?>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'txt_username')->textInput(['maxlength' => true, 'placeholder' => 'Nombre'])->label(false) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'txt_apellido_paterno')->textInput(['maxlength' => true, 'placeholder' => 'Apellido paterno'])->label(false) ?>
                </div>
            </div>
            
            <h4>Datos de Usuario</h4>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'txt_email')->textInput(['maxlength' => true, 'placeholder' => 'correo eléctronico (Este será el usuario con el cual iniciara sesión)'])->label(false) ?>
                </div>
            </div>         

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?= Html::submitButton('<span class="ladda-label"><i class="icon wb-plus"></i> Guardar usuario</span>', ['class' => "btn btn-success ladda-button btn-usuarios-add", "data-style" => "zoom-in", "id" => "btn-guardar-usuario"]) ?>
                    </div>
                </div>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
 $this->registerJs(
    '
    $(document).ready(function(){
        $("#entusuarios-txt_auth_item").on("change", function(){
            var usuarioCallCenter = "'.Constantes::USUARIO_CALL_CENTER.'";
            var usuarioSupervisor = "'.Constantes::USUARIO_SUPERVISOR.'";
            var usuarioAdministrador = "'.Constantes::USUARIO_ADMINISTRADOR_CC.'";
            var usuarioMaster = "'.Constantes::USUARIO_MASTER_CALL_CENTER.'";
            var elemento = $(this);

            if(elemento.val()==usuarioCallCenter || elemento.val()==usuarioSupervisor || elemento.val()==usuarioAdministrador || elemento.val()==usuarioMaster){
                $(".contenedor-call-center").show();
            }else{
                $(".contenedor-call-center").hide();
            }

        });
       
    });
    
    ',
    View::POS_END,
    'aprobar-cita'
    );