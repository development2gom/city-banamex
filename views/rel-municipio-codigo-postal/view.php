<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RelMunicipioCodigoPostal */

$this->title = $model->id_municipio;
$this->params['breadcrumbs'][] = ['label' => 'Rel Municipio Codigo Postals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rel-municipio-codigo-postal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_municipio' => $model->id_municipio, 'txt_codigo_postal' => $model->txt_codigo_postal], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_municipio' => $model->id_municipio, 'txt_codigo_postal' => $model->txt_codigo_postal], [
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
            'id_municipio',
            'txt_codigo_postal',
        ],
    ]) ?>

</div>
