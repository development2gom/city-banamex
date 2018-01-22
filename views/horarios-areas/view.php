<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EntHorariosAreas */

$this->title = $model->id_horario_area;
$this->params['breadcrumbs'][] = ['label' => 'Ent Horarios Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-horarios-areas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_horario_area], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_horario_area], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_horario_area',
            'id_area',
            'id_dia',
            'txt_hora_inicial',
            'txt_hora_final',
            'num_disponibles',
        ],
    ]) ?>

</div>
