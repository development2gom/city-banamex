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
use app\models\Constantes;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\models\CatTiposTramites;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ModUsuarios\models\EntUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

 $this->title = 'Citas';
 $this->params['classBody'] = "site-navbar-small site-menubar-hide";
 if(\Yii::$app->user->can(Constantes::USUARIO_CALL_CENTER)){
      $this->params['headerActions'] = '<a class="btn btn-success ladda-button no-pjax" href="'.Url::base().'/citas/create" data-style="zoom-in"><span class="ladda-label"><i class="icon wb-plus"></i>Agregar</span></a>';
 }
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon pe-7s-headphones"></i>Citas',
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false];

// $this->registerCssFile(
//     '@web/webAssets/css/citas/index.css',
//     ['depends' => [\app\assets\AppAsset::className()]]
// );

$this->registerJsFile(
    '@web/webAssets/js/citas/index.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>




<div class="row">
    
    <?php
    if(\Yii::$app->user->can(Constantes::USUARIO_SUPERVISOR) || \Yii::$app->user->can(Constantes::USUARIO_SUPERVISOR_TELCEL)){?>
    <div class="col-md-12">
        <div class="list-group list-group-full">
            <?php
            foreach($status as $statu){
                $statusColor = EntCitas::getColorStatus($statu->id_statu_cita);
            ?>

            <!-- <a class="list-group-item" href="<?=Url::base()?>/citas/index?EntCitasSearch[id_status]=<?=$statu->id_statu_cita?>">
                <i class="icon wb-calendar" aria-hidden="true"></i>  
                <span class="float-right badge badge-<?=$statusColor?> badge-pill text-white">
                    <?=count($statu->entCitas)?>
                </span>
                <?=$statu->txt_nombre?>
            </a> -->
            
            <!-- Active -->
            <a class="list-group-item list-group-item-tag" href="<?=Url::base()?>/citas/index?EntCitasSearch[id_status]=<?=$statu->id_statu_cita?>">
                <span class="badge badge-pill badge-<?=$statusColor?>"><?=count($statu->entCitas)?></span>
                <?=$statu->txt_nombre?>
            </a>
            
            <?php
                }
            ?>
            <div class="list-group-item-lg">
                <a class="list-group-item-more" href="<?=Url::base()?>/citas/index">
                    Mostrar todas
                </a>
            </div>
           
        </div>
    </div>    
    <?php
    }
    ?>

</div>    

<!-- <div class="row">
    <div class="col-md-12 <?=\Yii::$app->user->can(Constantes::USUARIO_SUPERVISOR) || \Yii::$app->user->can(Constantes::USUARIO_SUPERVISOR_TELCEL)?"9":"12"?>">
        <div class="panel-collapse collapse in show" id="exampleCollapseDefaultOne" aria-labelledby="exampleHeadingDefaultOne" role="tabpanel" aria-expanded="true">
            <?php # echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
</div> -->


    <?php

    $gridColumns =  [
        'txt_identificador_cliente',
        [
            'attribute' => 'id_status',
            'format'=>'raw',
            'value'=>function($data){
                
                return $data->idStatus->txt_nombre;
            }
        ],
        'txt_telefono',
        [
            'attribute'=>'txt_nombre',
            'format'=>'raw',
            'value'=>function($data){
                return $data->nombreCompleto;
            }
        ],

        [
            'attribute'=>'id_tipo_tramite',
            'value'=>'idTipoTramite.txt_nombre'
        ],
        [
            'attribute'=>'fch_creacion',
            'format'=>'raw',
            'value'=>function($data){

                return Calendario::getDateCompleteHour($data->fch_creacion);
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
            
            'value'=>'idEnvio.txt_tracking'
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
    <div class="panel-table">
        <?php
        
        echo GridView::widget([
                // 'tableOptions' => [
                //     "class" => "table"
                // ],
                'filterModel' => $searchModel,
                'pjax'=>true,
                'pjaxSettings'=>[
                    'options'=>[
                      'linkSelector'=>"a:not(.no-pjax)",
                      'id'=>'pjax-usuarios'
                    ]
                  ],
                'dataProvider' => $dataProvider,
                'columns' =>[
                    'txt_identificador_cliente',
                    [
                        'filter'=>ArrayHelper::map($status, 'id_statu_cita', 'txt_nombre'),
                        'filterInputOptions'=>[
                            'class'=>'form-control',
                            'prompt'=>"Ver todos"
                        ],
                        'attribute' => 'id_status',
                        'format'=>'raw',
                        'value'=>function($data){
                            
                            $statusColor = EntCitas::getColorStatus($data->id_status);
                            $classActualizar = "actualizar-envio";
                            $isBuscar = false;
                            $dataEnvio = '';
                            if($data->id_envio && ($data->id_status != Constantes::STATUS_ENTREGADO || Constantes::STATUS_CANCELADO)){
                                $isBuscar = true;
                                $dataEnvio = $data->txtTracking;
                            }
                            return Html::a(
                                $data->idStatus->txt_nombre,
                                Url::to(['citas/view', 'token' => $data->txt_token]), 
                                [
                                    'id'=>"js-cita-envio-".$data->txt_token,
                                    'data-envio'=>$dataEnvio,
                                    'class'=>'btn badge '.$statusColor.' no-pjax '.($isBuscar?$classActualizar:''),
                                ]
                            );
                        }
                    ],
                    'txt_telefono',
                    [
                        'attribute'=>'nombreCompleto',
                        //'filter'=>"",
                        'format'=>'raw',
                        'value'=>function($data){
                            return $data->nombreCompleto;
                        }
                    ],
                    [
                        'filter'=>ArrayHelper::map(CatTiposTramites::find()->all(), 'id_tramite', 'txt_nombre'),
                        'filterInputOptions'=>[
                            'class'=>'form-control',
                            'prompt'=>"Ver todos"
                        ],
                        'attribute'=>'id_tipo_tramite',
                        'value'=>'idTipoTramite.txt_nombre'
                    ],
                    [
                        'filter'=>DatePicker::widget([
                            'model'=>$searchModel,
                            'attribute'=>'fch_creacion',
                            'pickerButton'=>false,
                            'removeButton'=>false,
                            'type' => DatePicker::TYPE_INPUT,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd-mm-yyyy',
                                'clearBtn'=>true,
                            ]
                        ]),
                        'attribute'=>'fch_creacion',
                        'format'=>'raw',
                        'value'=>function($data){
            
                            return Calendario::getDateSimple($data->fch_creacion);
                        }
                    ],
                    [
                        'filter'=>DatePicker::widget([
                            'model'=>$searchModel,
                            'attribute'=>'fch_cita',
                            'pickerButton'=>false,
                            'removeButton'=>false,
                            'type' => DatePicker::TYPE_INPUT,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]),
                        'attribute'=>'fch_cita',
                        'format'=>'raw',
                        'value'=>function($data){
                            if(!$data->fch_cita){
                                return "(no definido)";
                            }
                            return Calendario::getDateSimple($data->fch_cita);
                        }
                    ],
                    [
                        'attribute'=>'txtTracking',
                        'value'=>'txtTracking',
                        'format'=>'raw',
                        'value'=>function($data){

                            if($data->id_envio){
                                return Html::a(
                                    $data->txtTracking,
                                    Url::to(['citas/ver-status-envio', 'token' => $data->idEnvio->txt_token]),
                                    [
                                        'class'=>'id-send no-pjax'
                                    ]
                                );
                            }

                            return "<span class='id-send-error'>---</span>";

                            
                        }
                    ],
                    
                ],
                'panelTemplate' => "{panelHeading}\n{items}\n{summary}\n{pager}",
                "panelHeadingTemplate"=>"{export}",
                'responsive'=>true,
                'striped'=>false,
                'hover'=>false,
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
                    ],
                    'options'=>[
                        'class' => 'btn btn-exportar',
                    ]
                ],
                'exportConfig'=>[
                    GridView::CSV => [
                        'label' => Yii::t('kvgrid', 'CSV'),
                        'icon' =>'file-code-o', 
                        'iconOptions' => false,
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
                        ],
                    ],
                ],
                'pager'=>[
                    'linkOptions' => [
                        'class' => 'page-link'
                    ],
                    'pageCssClass'=>'page-item',
                    'prevPageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item',
                    'firstPageCssClass' => 'page-item',
                    'lastPageCssClass' => 'page-item',
                    'maxButtonCount' => '5',
                ]
            ]) ?>
</div>    


<style>
.datepicker{
    z-index:9999 !important;
}

</style>

   
