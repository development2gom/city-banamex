
<?php 
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use app\models\Constantes;
use yii\bootstrap\Html;
use app\models\CatTiposCancelacion;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

if(\Yii::$app->user->can(Constantes::USUARIO_SUPERVISOR)){
    $tiposCancelacion = CatTiposCancelacion::find()->where(['txt_tipo'=>Constantes::CALL_CENTER])->all();
}

if(\Yii::$app->user->can(Constantes::USUARIO_SUPERVISOR_TELCEL)){
    $tiposCancelacion = CatTiposCancelacion::find()->where(['txt_tipo'=>Constantes::TELCEL])->all();
}
    $model->scenario = 'cancelar';
    Modal::begin([
        'options'=>[
            'tabindex' => false
        ],
        'header'=>'<h4>Motivo de cancelación</h4>',
        'id'=>'cita-cancelacion-modal',
        
        //'size'=>'modal-lg',
    ]);

        $form = ActiveForm::begin([
            'id'=>'cita-cancelacion-form',
            'action'=>'cancelar?token='.$model->txt_token
            ]);

            echo $form->field($model, 'id_tipo_cancelacion')
            ->widget(Select2::classname(), [
                //'value'=>$areaDefault->id_area,
                'data' => ArrayHelper::map($tiposCancelacion, 'id_tipo_cancelacion', 'txt_nombre'),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccionar motivo de cancelación'],
                
            ]);


        echo Html::submitButton('Cancelar cita', ['class' => 'btn btn-warning']);

    ActiveForm::end();
    Modal::end();

?>