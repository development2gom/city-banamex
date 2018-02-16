<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['update'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'txt_username') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_apellido_paterno') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_email') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_email') ?>
        </div>
    </div>
    
    <div class="form-group text-center">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>