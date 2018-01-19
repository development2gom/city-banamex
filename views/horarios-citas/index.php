<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntHorariosAreasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ent Horarios Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-horarios-areas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ent Horarios Areas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_horario_area',
            'id_area',
            'id_dia',
            'txt_hora_inicial',
            'txt_hora_final',
            // 'num_disponibles',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
