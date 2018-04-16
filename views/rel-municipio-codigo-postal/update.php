<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RelMunicipioCodigoPostal */

$this->title = 'Update Rel Municipio Codigo Postal: ' . $model->id_municipio;
$this->params['breadcrumbs'][] = ['label' => 'Rel Municipio Codigo Postals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_municipio, 'url' => ['view', 'id_municipio' => $model->id_municipio, 'txt_codigo_postal' => $model->txt_codigo_postal]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rel-municipio-codigo-postal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
