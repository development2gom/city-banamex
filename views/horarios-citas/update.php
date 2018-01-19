<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EntHorariosAreas */

$this->title = 'Update Ent Horarios Areas: ' . $model->id_horario_area;
$this->params['breadcrumbs'][] = ['label' => 'Ent Horarios Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_horario_area, 'url' => ['view', 'id' => $model->id_horario_area]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ent-horarios-areas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
