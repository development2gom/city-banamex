<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel-search">

    <h3 class="panel-search-title">Usuarios</h3>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'panel-search-form'
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'txt_username') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'txt_apellido_paterno') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_email') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_email') ?>
        </div>
        <div class="col-md-2">
            <div class="form-group form-group-btns">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-search']) ?>
                <?= Html::resetButton('Limpiar', ['class' => 'btn btn-clear']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>