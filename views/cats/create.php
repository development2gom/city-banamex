<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatCats */

$this->title = 'Create Cat Cats';
$this->params['breadcrumbs'][] = ['label' => 'Cat Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-cats-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
