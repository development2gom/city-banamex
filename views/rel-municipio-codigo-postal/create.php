<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RelMunicipioCodigoPostal */

$this->title = 'Create Rel Municipio Codigo Postal';
$this->params['breadcrumbs'][] = ['label' => 'Rel Municipio Codigo Postals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rel-municipio-codigo-postal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
