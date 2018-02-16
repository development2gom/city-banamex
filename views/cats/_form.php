<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatCats */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-cats-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_calle_numero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_colonia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_codigo_postal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_municipio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'b_habilitado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
