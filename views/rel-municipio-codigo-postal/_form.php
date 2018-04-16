<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RelMunicipioCodigoPostal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rel-municipio-codigo-postal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_municipio')->textInput() ?>

    <?= $form->field($model, 'txt_codigo_postal')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
