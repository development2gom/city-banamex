<?php
use kartik\date\DatePicker;
use app\models\Calendario;
use app\modules\ModUsuarios\models\Utils;
$this->title = 'Subir evidencias';
$this->params['classBody'] = "site-navbar-small site-menubar-hide";

$this->registerCssFile(
    'http://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);


$this->registerJsFile(
    'http://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
  '@web/webAssets/js/citas/subir-archivos.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

?>

 <!-- Panel jQuery File Upload -->
 <div class="panel">
   <div class="panel-body">
     <div class="row">
       <div class="col-md-12">
        <?=DatePicker::widget([
                        'id'=>"fecha",
                        'name' => 'date',
                        'value'=>Utils::changeFormatDate(Calendario::getFechaActual()),
                        'options' => ['placeholder' => 'Fecha'],
                       
                        
                        'type' => DatePicker::TYPE_INPUT,
                        
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'autoclose' => true,
                           
                            'maxViewMode'=>2
                        ],
                       ]);?>
       </div>
     </div>
     <div class="row">
            <div class="col-md-12">
              <div id="fileuploader">Upload</div>
            </div>
      </div>
    <div class="row">
      <div class="col-md-12">
        <button class"btn btn-success" id="js-subir-archivos">Subir todos los archivos</button>
      </div>
    </div>
  </div>
</div>
     
