<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatCatsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cat Cats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-cats-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cat Cats', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_cat',
            'txt_nombre',
            'txt_estado',
            'txt_calle_numero',
            'txt_colonia',
            // 'txt_codigo_postal',
            // 'txt_municipio',
            // 'b_habilitado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
