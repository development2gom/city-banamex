<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatEquipos */

$this->title = 'Create Cat Equipos';
$this->params['breadcrumbs'][] = ['label' => 'Cat Equipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-equipos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
