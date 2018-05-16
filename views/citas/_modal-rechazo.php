
<?php 
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use app\models\Constantes;
use yii\bootstrap\Html;
use app\models\CatTiposCancelacion;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


    $model->scenario = 'rechazo';
    Modal::begin([
        'options'=>[
            'tabindex' => false
        ],
        'header'=>'<h4>Motivo de rechazo</h4>',
        'id'=>'cita-rechazo-modal',
        
        //'size'=>'modal-lg',
    ]);

        $form = ActiveForm::begin([
            'id'=>'cita-rechazo-form',
            'action'=>'rechazar?token='.$model->txt_token
            ]);

            echo $form->field($model, 'txt_motivo_rechazo')->textarea();



        echo Html::submitButton('Rechazar cita', ['class' => 'btn btn-warning']);

    ActiveForm::end();
    Modal::end();

?>