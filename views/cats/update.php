<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatCats */

$this->title = 'Update Cat Cats: ' . $model->id_cat;
$this->params['breadcrumbs'][] = ['label' => 'Cat Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_cat, 'url' => ['view', 'id' => $model->id_cat]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cat-cats-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
