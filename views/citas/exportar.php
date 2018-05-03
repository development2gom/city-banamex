<?php
use kartik\export\ExportMenu;
use app\models\Calendario;

$this->title = 'Exportar datos';
$this->params['classBody'] = "site-navbar-small site-menubar-hide";

$gridColumns =  [
    'txt_identificador_cliente',
     'txt_telefono',
     [
        'attribute'=>'id_envio',
        'value'=>'idEnvio.txt_tracking'
    ],

    [
        'attribute'=>'idMunicipio.idTipo.txt_nombre',
        'label'=>'Tipo de entrega',
    ],
    [
        'attribute'=>'idMunicipio.diasServicio',
        'label'=>'Frecuencia',
    ], 
    [
        'attribute'=>'idTipoTramite.txt_nombre',
        'label'=>'Tipo tramite',
    ], 
    [
        'attribute'=>'b_entrega_cat',
        'label'=>'Entrega en',
        'format'=>'raw',
        'value'=>function($data){
            if($data->b_entrega_cat){
                return "CAC";
            }else{
                return "Domicilio";
            }
        }
    ],
    [
        'attribute'=>'idCallCenter.txt_nombre',
        'label'=>'Fza venta',
    ],
    [
        'attribute'=>'fch_creacion',
        'label'=>'Fecha de creación',
        'format'=>'raw',
        'value'=>function($data){
           return Calendario::getDateComplete($data->fch_creacion);
        }
    ],   
    [
        'attribute'=>'fch_cita',
        'label'=>'Fecha de cita',
        'format'=>'raw',
        'value'=>function($data){
           return Calendario::getDateComplete($data->fch_cita);
        }
    ],  
    [
        'attribute'=>'idHorario',
        'label'=>'Hora de cita',
        'format'=>'raw',
        'value'=>function($data){
           return $data->idHorario->txt_hora_inicial." - ".$data->idHorario->txt_hora_final;
        }
    ],  
    [
        'attribute'=>'idStatus.txt_nombre',
        'label'=>'Estatus de la cita',
    ], 
    [
        'attribute'=>'nombreCompleto',   
        'label'=>'Nombre completo'
    ],
    'txt_equipo',
    [
        'attribute'=>'txt_imei',
        'format'=>'raw',
    ],
    [
        'attribute'=>'txt_iccid',
        'format'=>'raw'
    ],
    'txt_promocional',
    'txt_tpv',
    'txt_calle_numero',
    'txt_colonia',
    'txt_municipio',
    'txt_estado',
    'txt_codigo_postal',
    'txt_entre_calles',
    
] ;    


// Renders a export dropdown menu
echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    //"pjaxContainerId"=>'pjax-citas',
    'target' => ExportMenu::TARGET_BLANK,
    'showConfirmAlert'=>false,
    'fontAwesome' => true,
    'asDropdown' => false,
    
     'exportConfig'=>[
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_CSV => [
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
            'writer' => ExportMenu::FORMAT_CSV,
            'config' => [
                'colDelimiter' => ",",
                'rowDelimiter' => "\r\n",
            ],
        ],
        ExportMenu::FORMAT_TEXT =>false,
        ExportMenu::FORMAT_PDF => false,
        ExportMenu::FORMAT_EXCEL => false,
        ExportMenu::FORMAT_EXCEL_X => false,
    ],
    
]);