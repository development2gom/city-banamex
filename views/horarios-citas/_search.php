<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntHorariosAreasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-horarios-areas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_horario_area') ?>

    <?= $form->field($model, 'id_area') ?>

    <?= $form->field($model, 'id_dia') ?>

    <?= $form->field($model, 'txt_hora_inicial') ?>

    <?= $form->field($model, 'txt_hora_final') ?>

    <?php // echo $form->field($model, 'num_disponibles') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
