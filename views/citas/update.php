<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */

$this->title = 'Update Ent Citas: ' . $model->id_cita;
$this->params['breadcrumbs'][] = ['label' => 'Ent Citas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_cita, 'url' => ['view', 'id' => $model->id_cita]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ent-citas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
