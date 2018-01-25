<?php

use yii\helpers\Url;
use yii\helpers\Html;
$this->title = 'Importar data';
$this->params['breadcrumbs'][] = [
  'label' => '<i class="icon pe-users"></i>'.$this->title, 
  'encode' => false,
  'template'=>'<li class="breadcrumb-item">{link}</li>', 
];

$this->params['headerActions'] = '<a class="btn btn-primary" href="'.Url::base().'/usuarios/descargar-layout"><i class="icon pe-7s-cloud-download"></i> Descargar layout</a>';

$this->params['classBody'] = "site-navbar-small";

$this->registerCssFile(
  '@web/webAssets/templates/classic/global/vendor/dropify/dropify.css',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/templates/classic/global/vendor/dropify/dropify.min.js',
    ['depends' => [\app\assets\AppAsset::className()]]
  );
  

$this->registerJsFile(
  '@web/webAssets/templates/classic/global/js/Plugin/dropify.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

?>

<!-- Panel Dropify -->
<div class="panel">
        <div class="panel-body container-fluid">
          <div class="row">
            <div class="col-md-12">
              <!-- Example Default -->
              <div class="example-wrap">
                <div class="example">
                    <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data']) ?>
                        <?=Html::fileInput("file-import","", ["id"=>"input-file-now", "data-plugin"=>"dropify", "data-default-file"=>"", "data-allowed-file-extensions"=>"xlsx"])?>
                        
                        <div class="text-center">
                            <?=Html::submitButton("Cargar información", ["class"=>"btn btn-success"])?>
                        </div>
                    <?= Html::endForm() ?>
                </div>
              </div>
              <!-- End Example Default -->
            </div>
            
          </div>
        </div>
      </div>
      <!-- End Panel Dropify -->