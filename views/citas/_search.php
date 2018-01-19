<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CatStatusCitas;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-citas-search">

    <?php $form = ActiveForm::begin([
        'id'=>'form-search',
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true,'class'=>'page-search-form' ]
    ]); ?>

    <div class="row">
        <div class="col-md-4">
             <?= $form->field($model, 'id_status')
                                ->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(CatStatusCitas::find("b_habilitado=1")->orderBy("txt_nombre")->all(), 'id_statu_cita', 'txt_nombre'),
                                    'language' => 'es',
                                    'options' => ['placeholder' => 'Seleccionar estatus'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                ?> 
        </div>

        <div class="col-md-4">
            <?php  echo $form->field($model, 'txt_telefono')->textInput(['maxlength' => true, 'class'=>'form-control input-number']); ?>
        </div>

        <div class="col-md-4">
            <?php  echo $form->field($model, 'fch_cita')->widget(DatePicker::classname(), [
                    'pickerButton'=>false,
                    'removeButton'=>false,
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd-mm-yyyy'
                    ]]);
            ?>
        </div>
    </div>


    <?php // $form->field($model, 'id_cita') ?>

    <?php // $form->field($model, 'id_tipo_tramite') ?>

    <?php // $form->field($model, 'id_equipo') ?>

    <?php // $form->field($model, 'id_sim_card') ?>

    <?php // $form->field($model, 'id_area') ?>

    <?php // echo $form->field($model, 'id_tipo_entrega') ?>

    <?php // echo $form->field($model, 'id_usuario') ?>
    

    <?php // echo $form->field($model, 'num_dias_servicio') ?>

    <?php // echo $form->field($model, 'txt_token_envio') ?>

    <?php // echo $form->field($model, 'txt_token') ?>

    <?php // echo $form->field($model, 'txt_clave_sap_equipo') ?>

    <?php // echo $form->field($model, 'txt_descripcion_equipo') ?>

    <?php // echo $form->field($model, 'txt_serie_equipo') ?>

    <?php // echo $form->field($model, 'txt_iccid') ?>

    <?php // echo $form->field($model, 'txt_imei') ?>


    <?php // echo $form->field($model, 'txt_clave_sim_card') ?>

    <?php // echo $form->field($model, 'txt_descripcion_sim') ?>

    <?php // echo $form->field($model, 'txt_serie_sim_card') ?>

    <?php // echo $form->field($model, 'txt_nombre_completo_cliente') ?>

    <?php // echo $form->field($model, 'txt_numero_referencia') ?>

    <?php // echo $form->field($model, 'txt_numero_referencia_2') ?>

    <?php // echo $form->field($model, 'txt_numero_referencia_3') ?>

    <?php // echo $form->field($model, 'txt_calle_numero') ?>

    <?php // echo $form->field($model, 'txt_colonia') ?>

    <?php // echo $form->field($model, 'txt_codigo_postal') ?>

    <?php // echo $form->field($model, 'txt_municipio') ?>

    <?php // echo $form->field($model, 'txt_entre_calles') ?>

    <?php // echo $form->field($model, 'txt_observaciones_punto_referencia') ?>

    

    <?php // echo $form->field($model, 'fch_hora_cita') ?>

    <div class="form-group">
    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary js-search-button', 'name'=>'isOpen', 'value'=>Yii::$app->request->get('isOpen')?'1':'0']) ?>
    <?= Html::button('Limpiar', ['class' => 'btn btn-default js-limpiar-campos']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
