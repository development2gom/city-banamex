<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatEquipos */

$this->title = 'Update Cat Equipos: ' . $model->id_equipo;
$this->params['breadcrumbs'][] = ['label' => 'Cat Equipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_equipo, 'url' => ['view', 'id' => $model->id_equipo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cat-equipos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
