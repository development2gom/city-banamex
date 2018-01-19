<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */
/* @var $form yii\widgets\ActiveForm */

$equipo = $model->idEquipo;
?>

    <?php $form = ActiveForm::begin([
        'errorCssClass'=>"has-danger",
        'fieldConfig' => [
            "labelOptions" => [
                "class" => "form-control-label"
            ]
        ]
    ]); ?>
    <div class="panel">
        <div class="panel-heading">
            <h5 class="panel-title">
                Datos generales
            </h5>
        </div>
        <div class="panel-body pt-20">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_telefono')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_apellido_paterno')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_apellido_materno')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?php 
                        echo $form->field($model, 'fch_nacimiento')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => '16-12-1990'],
                            'pickerButton'=>false,
                            'removeButton'=>false,
                            'type' => DatePicker::TYPE_INPUT,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]);
                    ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_rfc')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_email')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'id_tipo_tramite')
                                    ->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map($tiposTramites, 'id_tramite', 'txt_nombre'),
                                        'language' => 'es',
                                        'options' => ['placeholder' => 'Seleccionar tipo de trámite'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                    ?>                
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'id_tipo_cliente')
                                        ->widget(Select2::classname(), [
                                            'data' => ArrayHelper::map($tiposClientes, 'id_tipo_cliente', 'txt_nombre'),
                                            'language' => 'es',
                                            'options' => ['placeholder' => 'Seleccionar tipo de cliente'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                        ?>  
                </div>
                <div class="col-md-3">
                <?php
                    require(__DIR__ . '/../components/select2.php');
                    $url = Url::to(['equipos/buscar-equipo']);
                    $valEquipo = empty($model->id_equipo) ? '' : $equipo->txt_nombre;
                    //$equipo = empty($model->id_equipo) ? '' : CatEquipos::findOne($model->id_equipo)->txt_nombre;
                    // render your widget
                    echo $form->field($model, 'id_equipo')->widget(Select2::classname(), [
                        //'initValueText' => $cityDesc,
                        'options' => ['placeholder' => 'Seleccionar equipo'],
                        'pluginOptions' => [
                            //'allowClear' => true,
                            'minimumInputLength' => 1,
                            'ajax' => [
                                'url' => $url,
                                'dataType' => 'json',
                                'delay' => 250,
                                'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                'processResults' => new JsExpression($resultsJs),
                                'cache' => true
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('formatRepoEquipo'),
                            'templateSelection' => new JsExpression('function (equipo) { 
                                if(equipo.txt_nombre){
                                    return equipo.txt_nombre; 
                                }else{
                                    return "'.$valEquipo.'"
                                } }'),
                        ],
                    ]);
                
                ?>       
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_numero_telefonico_nuevo')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="panel">
        <div class="panel-heading">
            <h5 class="panel-title">
                Datos de contacto
            </h5>
        </div>
        <div class="panel-body pt-20">
            <div class="row">
                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-control-label" for="entcitas-txt_codigo_postal">Buscar código postal</label>
                        <?php
                        require(__DIR__ . '/../components/select2.php');
                        $url = Url::to(['codigos-postales/buscar-codigo']);
                        // render your widget
                        echo Select2::widget( [
                            'name'=>"codigo-postal",
                            'options' => ['placeholder' => 'Buscar codigo postal'],
                            'pluginEvents'=>[
                                "select2:select" => "function(e) { 
                                    var codigoPostal = e.params.data.id;
                                    $('#entcitas-txt_codigo_postal').val(codigoPostal);
                                    buscarDatosLocalizacion(codigoPostal);
                                }",
                                "select2:unselect" => "function() { 
                                    $('#entcitas-txt_codigo_postal').val('');
                                 }"
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 3,
                                'ajax' => [
                                    'url' => $url,
                                    'dataType' => 'json',
                                    'delay' => 250,
                                    'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                    'processResults' => new JsExpression($resultsJs),
                                    'cache' => true
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(equipo) { return equipo.txt_nombre; }'),
                                'templateSelection' => new JsExpression('function (equipo) {return equipo.txt_nombre; }'),
                            ],
                        ]);
                    ?>
                    </div>
                    
                </div> -->
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_codigo_postal')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'txt_calle_numero')->textInput(['maxlength' => true]) ?>
                </div>
                
                    

               
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'txt_colonia')->textInput(['maxlength' => true]) ?>
                </div>    
                <div class="col-md-4">
                
                    <?= $form->field($model, 'txt_municipio')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'txt_estado')->textInput(['maxlength' => true]) ?>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'txt_entre_calles')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'txt_observaciones_punto_referencia')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_numero_referencia')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_numero_referencia_2')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_numero_referencia_3')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'id_tipo_identificacion')
                                            ->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map($tiposIdentificaciones, 'id_tipo_identificacion', 'txt_nombre'),
                                                'language' => 'es',
                                                'options' => ['placeholder' => 'Seleccionar identificación'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                        ?>  
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'txt_folio_identificacion')->textInput(['maxlength' => true]) ?>        
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <h5 class="panel-title">
                Datos de la cita
            </h5>
        </div>
        <div class="panel-body pt-20">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'id_area')
                                                ->widget(Select2::classname(), [
                                                    //'value'=>$areaDefault->id_area,
                                                    'data' => ArrayHelper::map($areas, 'id_area', 'txt_nombre'),
                                                    'language' => 'es',
                                                    'options' => ['placeholder' => 'Seleccionar identificación'],
                                                    
                                                ]);
                        ?>  
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <?=Html::label("Días de servicio", "num_dias_servicio", ["class"=>"form-control-label"])?>
                        <?=Html::textInput("num_dias_servicio", $model->num_dias_servicio, ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'num_dias_servicio' ])?>
                    </div>    
                        <?= $form->field($model, 'num_dias_servicio')->hiddenInput(['maxlength' => true])->label(false) ?>
                </div>
                <div class="col-md-3">
                    <?php
                    $startDate = $model->fch_cita;
                    //$model->fch_cita = null;
                    echo $form->field($model, 'fch_cita')->widget(DatePicker::classname(), [
                        //'options' => ['placeholder' => '16/12/1990'],
                        'pickerButton'=>false,
                        'removeButton'=>false,
                        'type' => DatePicker::TYPE_INPUT,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'dd-mm-yyyy',
                            'daysOfWeekDisabled'=> "0",
                            'startDate' => $startDate, //date("d-m-Y")
                        ]
                        // 'language' => 'es',
                        // 'options'=>['class'=>'form-control'],
                        // 'dateFormat' => 'dd-MM-yyyy',
                        // 'clientOptions' => [
                        //     'minDate' => $tresDias, //date("d-m-Y")
                        //     'dayNamesShort' => ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
                        //     'dayNamesMin' => ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                        //     'beforeShowDay' => false             
                        // ],
                    ])
                    ?>
                </div>
                
                <div class="col-md-3"> 
                    <?php
            
                    echo $form->field($model, 'id_horario')->widget(DepDrop::classname(), [
                        
                        'options' => ['placeholder' => 'Seleccionar ...'],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options'=>[
                            'pluginOptions'=>[
                                
                                'allowClear'=>true,
                                'escapeMarkup' => new JsExpression('function (markup) { 
                                    
                                    return markup; }'),
                                'templateResult' => new JsExpression('formatRepo'),
                            ],
                            ],
                        'pluginOptions'=>[
                            'initialize' => true,
                            'url' => Url::to(['/horarios-areas/get-horarios-disponibilidad-by-area?horario='.$model->id_horario]),
                            'depends'=>['entcitas-fch_cita', 'entcitas-id_area'],
                            'params'=>[
                                'entcitas-id_area',
                                'entcitas-fch_cita'
                            ],  
                            'loadingText' => 'Cargando horarios ...',
                            
                        ]
                        
                    ]);
                ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton("<span class='ladda-label'>".($model->isNewRecord ? 'Generar cita' : 'Actualizar cita')."</span>", ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')." float-right ladda-button", "data-style"=>"zoom-in"]) ?>
    </div>

    <?php ActiveForm::end(); ?>
