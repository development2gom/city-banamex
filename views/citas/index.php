<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use app\components\CustomLinkSorter;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\models\Calendario;
use kartik\export\ExportMenu;
use app\models\EntCitas;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ModUsuarios\models\EntUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citas';
$this->params['classBody'] = "site-navbar-small site-menubar-hide";
$this->params['headerActions'] = '<a class="btn btn-success ladda-button" href="'.Url::base().'/citas/create" data-style="zoom-in"><span class="ladda-label"><i class="icon wb-plus"></i>Agregar</span></a>';
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-calendar"></i>Citas',
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false];

$this->registerCssFile(
    '@web/webAssets/css/citas/index.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/js/citas/index.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>


<?php Pjax::begin(['id' => 'citas', 'timeout'=>'0', 'linkSelector'=>'table thead a, a.list-group-item']) ?>




<div class="row">
    <div class="col-md-3">
        <div class="list-group bg-blue-grey-100">
            <?php
            foreach($status as $statu){
                $statusColor = EntCitas::getColorStatus($statu->id_statu_cita);
            ?>

            <a class="list-group-item blue-grey-500" href="<?=Url::base()?>/citas/index?EntCitasSearch[id_status]=<?=$statu->id_statu_cita?>">
                <i class="icon wb-calendar" aria-hidden="true"></i>  
                <span class="float-right badge badge-<?=$statusColor?> badge-pill text-white">
                    <?=count($statu->entCitas)?>
                </span>
                <?=$statu->txt_nombre?>
            </a>
            
            <?php
                }
            ?>
            <a class="list-group-item blue-grey-500" href="<?=Url::base()?>/citas/index">
                Mostrar todas
            </a>
           
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel-group" id="exampleAccordionDefault" aria-multiselectable="true" role="tablist">
            <div class="panel">
                <div class="panel-heading" id="exampleHeadingDefaultOne" role="tab">
                    <a class="panel-title  js-collapse" data-toggle="collapse" href="#exampleCollapseDefaultOne" data-parent="#exampleAccordionDefault" aria-expanded="true" aria-controls="exampleCollapseDefaultOne">
                        Buscar cita
                    </a>
                </div>
                <div class="panel-collapse collapse in show" id="exampleCollapseDefaultOne" aria-labelledby="exampleHeadingDefaultOne" role="tabpanel" aria-expanded="true">
                    <div class="panel-body">
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

 <!-- Panel -->
 <div class="panel" id="panel">
 
    <div class="js-ms-loading text-center">
            <h3>Cargando información</h3>
    </div>
    <div class="panel-body">

    <?php

    $gridColumns =  [
        [
            'attribute' => 'id_status',
            'format'=>'raw',
            'value'=>function($data){
                
                return $data->idStatus->txt_nombre;
            }
        ],
        'txt_telefono',
        [
            'attribute'=>'id_tipo_tramite',
            'value'=>'idTipoTramite.txt_nombre'
        ],
        [
            'attribute'=>'fch_creacion',
            'format'=>'raw',
            'value'=>function($data){

                return Calendario::getDateComplete($data->fch_creacion);
            }
        ],
        [
            'attribute'=>'fch_cita',
            'format'=>'raw',
            'value'=>function($data){
                if(!$data->fch_cita){
                    return "(no definido)";
                }
                return Calendario::getDateComplete($data->fch_cita);
            }
        ],
        [
            'attribute'=>'id_envio',
            'value'=>'idEnvio.txt_token'
        ],

        
    ] ;           

    $fullExportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'target' => ExportMenu::TARGET_BLANK,
        'showConfirmAlert'=>false,
        'fontAwesome' => true,
        'asDropdown' => false,
         'exportConfig'=>[
            ExportMenu::FORMAT_HTML => false,
            
            ExportMenu::FORMAT_TEXT =>false,
            ExportMenu::FORMAT_PDF => false,
            ExportMenu::FORMAT_EXCEL => false,
            ExportMenu::FORMAT_EXCEL_X => false,
        ],
        
    ]);

    ?>  
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' =>[
                    [
                        'attribute' => 'id_status',
                        'format'=>'raw',
                        'value'=>function($data){
                            
                            $statusColor = EntCitas::getColorStatus($data->id_status);
            
                            return Html::a(
                                $data->idStatus->txt_nombre,
                                Url::to(['citas/ver-cita', 'token' => $data->txt_token]), 
                                [
                                    'class'=>'btn badge badge-'.$statusColor.'',
                                ]
                            );
                        }
                    ],
                    'txt_telefono',
                    [
                        'attribute'=>'id_tipo_tramite',
                        'value'=>'idTipoTramite.txt_nombre'
                    ],
                    [
                        'attribute'=>'fch_creacion',
                        'format'=>'raw',
                        'value'=>function($data){
            
                            return Calendario::getDateComplete($data->fch_creacion);
                        }
                    ],
                    [
                        'attribute'=>'fch_cita',
                        'format'=>'raw',
                        'value'=>function($data){
                            if(!$data->fch_cita){
                                return "(no definido)";
                            }
                            return Calendario::getDateComplete($data->fch_cita);
                        }
                    ],
                    [
                        'attribute'=>'id_envio',
                        'value'=>'idEnvio.txt_token'
                    ],
                    
                ],
                'panelTemplate' => "{panelHeading}\n{items}\n{summary}\n{pager}",
                "panelHeadingTemplate"=>"<div class='float-right'>{export}</div>",
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
                'toolbar' => [
                    '{export}',
                ],
                'export' => [
                    'label' => 'Exportar',
                    'fontAwesome' => true,
                    'showConfirmAlert'=>false,
                   
                    'itemsAfter'=> [
                        '<li role="presentation" class="divider"></li>',
                        '<li class="dropdown-header">Export todos los datos</li>',
                        $fullExportMenu
                    ]
                ],
                'exportConfig'=>[
                    GridView::CSV => [
                        'label' => Yii::t('kvgrid', 'CSV'),
                        'icon' =>'file-code-o', 
                        'iconOptions' => ['class' => 'text-primary'],
                        'showHeader' => true,
                        'showPageSummary' => true,
                        'showFooter' => true,
                        'showCaption' => true,
                        'filename' => Yii::t('kvgrid', 'grid-export'),
                        'alertMsg' => Yii::t('kvgrid', 'The CSV export file will be generated for download.'),
                        'options' => ['title' => Yii::t('kvgrid', 'Comma Separated Values')],
                        'mime' => 'application/csv',
                        'config' => [
                            'colDelimiter' => ",",
                            'rowDelimiter' => "\r\n",
                        ]
                    ],
                ],
            ]) ?>
 
    </div>
   

    
</div>    
<!-- End Panel -->


<?php Pjax::end() ?>

   
