<?php
use kartik\export\ExportMenu;
use app\models\Calendario;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Exportar datos';
$this->params['classBody'] = "site-navbar-small site-menubar-hide";


$this->registerJsFile(
    '@web/webAssets/js/citas/exportar.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>

<style>
    .kv-container-from.form-control.field-entcitassearch-startdate, .kv-container-to.form-control.field-entcitassearch-enddate{
        padding:0;
    }
</style>

<div class="panel-citas-create">
    <?php $form = ActiveForm::begin([
        'errorCssClass'=>"has-danger",
        'action'=>'download-data',
        'method'=>"GET",
        'id'=>'form-search',
        'fieldConfig' => [
            "labelOptions" => [
                "class" => "form-control-label"
            ]
        ]
    ]); ?>

    <div class="citas-cont">
        <div class="row">
            <div class="col-md-12">
                <h5 class="panel-title">Exportar reporte</h5>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="form-group">
                    <?php
                    echo '<label class="control-label">Selecciona la fecha para exportar los datos. Dejar vacío si se requiere todo el historico</label>';
                    echo DatePicker::widget([
                        'model' => $modelSearch,
                        'attribute' => 'startDate',
                        'attribute2' => 'endDate',
                        'options' => ['placeholder' => 'Fecha inicio'],
                        'options2' => ['placeholder' => 'Fecha final'],
                        
                        'type' => DatePicker::TYPE_RANGE,
                        'form' => $form,
                        'separator' => '<i class="icon  fa-arrows-h"></i>',
                        
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'autoclose' => true,
                            'minViewMode'=> 1,
                            'maxViewMode'=>2
                        ],
                       ]);
                    ?>
                </div>    
            </div>
        </div>    
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-success', 'name'=>'isOpen', 'value'=>Yii::$app->request->get('isOpen')?'1':'0']) ?>
                    <?= Html::button('Limpiar', ['class' => 'btn btn-primary', "id"=>"limpiar-busqueda"]) ?>
                </div>
            </div>    
        </div>    
    </div>
    <?php ActiveForm::end(); ?>
</div>