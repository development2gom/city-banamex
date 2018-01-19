<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatEquiposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cat Equipos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-equipos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cat Equipos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_equipo',
            'txt_token',
            'txt_nombre',
            'txt_descripcion',
            'txt_clave_sap',
            // 'b_habilitado',
            // 'b_inventario_virtual',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
