<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */

$this->title = 'Generar cita';
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-calendar"></i> Citas', 
    'url' => ['index'],
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false
];

$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-plus"></i> '.$this->title,
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false];

$this->registerCssFile(
    '@web/webAssets/css/citas/create.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/js/citas/create.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>

<div class="panel">
    <div class="panel-body pt-0">
        <?= $this->render('_form', [
            'model' => $model,
            'tiposTramites'=>$tiposTramites,
            'tiposClientes'=>$tiposClientes,
            'tiposIdentificaciones'=>$tiposIdentificaciones,
            'areas'=>$areas,
            'areaDefault'=>$areaDefault
        ]) ?>
    </div>
</div>