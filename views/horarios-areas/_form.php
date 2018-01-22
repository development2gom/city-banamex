<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntHorariosAreas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-horarios-areas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_dia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_hora_inicial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_hora_final')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_disponibles')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
