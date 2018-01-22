<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Calendario;
use app\models\EntCitas;


/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */

$this->title = 'Ver cita '.'<span class="badge badge-'.EntCitas::getColorStatus($model->id_status   ).'">'.$model->idStatus->txt_nombre.'</span>';
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-calendar"></i> Citas', 
    'url' => ['index'],
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false
];
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-eye"></i> Ver cita',
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false];

$this->registerCssFile(
    '@web/webAssets/templates/classic/global/vendor/bootstrap-sweetalert/sweetalert.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerCssFile(
    '@web/webAssets/css/citas/create.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);


$this->registerJsFile(
    '@web/webAssets/js/citas/create.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/js/citas/view.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/templates/classic/global/js/Plugin/bootstrap-sweetalert.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>
<input class="token-cita" type="hidden" data-token="<?=$model->txt_token?>"/>
<div class="panel">
    <div class="panel-body pt-0">
        
        <?=$model->getBotonesSupervisor()?>
        
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

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Historial de cambios
        </h3>
    </div>
    <div class="panel-body">
    <?= GridView::widget([
                'dataProvider' => $historial,
                'columns' =>[
                    [
                        'attribute' => 'id_usuario',
                        'value'=>'idUsuario.txtAuthItem.description',
                        'label' => 'Tipo de usuario',
                    ],
                    [
                        'attribute'=>'id_usuario',
                        'value'=>'idUsuario.nombreCompleto',
                        'label' => 'Nombre usuario',
                    ],
                   'txt_modificacion',
                   [
                        'attribute'=>'fch_modificacion',
                        'format'=>'raw',
                        'label' => 'Fecha de modificación',
                        'value'=>function($data){
            
                            return Calendario::getDateComplete($data->fch_modificacion);
                        }
                    ],
                    
                ],
                'pjax'=>true,
                //'pjaxSettings'=>,
                'panelTemplate' => "{items}\n{summary}\n{pager}",
                //"panelHeadingTemplate"=>"<div class='pull-right'>{export}</div>",
                'responsive'=>true,
                'hover'=>true,
                'bordered'=>false,
                'panel' => [
                    'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Countries</h3>',
                    'type'=>'success',
                    'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
                    'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
                    'footer'=>false
                ],
               
            ]) ?>
    </div>
</div>