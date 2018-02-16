<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatCatsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-cats-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_cat') ?>

    <?= $form->field($model, 'txt_nombre') ?>

    <?= $form->field($model, 'txt_estado') ?>

    <?= $form->field($model, 'txt_calle_numero') ?>

    <?= $form->field($model, 'txt_colonia') ?>

    <?php // echo $form->field($model, 'txt_codigo_postal') ?>

    <?php // echo $form->field($model, 'txt_municipio') ?>

    <?php // echo $form->field($model, 'b_habilitado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
