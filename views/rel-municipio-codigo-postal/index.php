<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RelMunicipioCodigoPostalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rel Municipio Codigo Postals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rel-municipio-codigo-postal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rel Municipio Codigo Postal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_municipio',
            'txt_codigo_postal',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
