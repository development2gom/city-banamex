<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CatCats */

$this->title = $model->id_cat;
$this->params['breadcrumbs'][] = ['label' => 'Cat Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-cats-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_cat], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_cat], [
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
            'id_cat',
            'txt_nombre',
            'txt_estado',
            'txt_calle_numero',
            'txt_colonia',
            'txt_codigo_postal',
            'txt_municipio',
            'b_habilitado',
        ],
    ]) ?>

</div>
