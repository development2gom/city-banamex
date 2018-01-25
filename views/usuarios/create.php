<?php

use yii\helpers\Html;
use yii\web\View;
use app\models\Constantes;


/* @var $this yii\web\View */
/* @var $model app\models\EntUsuarios */

$this->title = 'Crear usuario';
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon pe-users"></i> Usuarios', 
    'encode' => false,
    'template'=>'<li class="breadcrumb-item">{link}</li>',
    'url' => ['index'], 
  ];
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-plus"></i>'.$this->title, 
    'encode' => false,
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
  ];

  $this->params['classBody'] = "site-navbar-small";  

  $this->registerJsFile(
    '@web/webAssets/js/sign-up.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
  );

  $this->registerCssFile(
    '@web/webAssets/css/signUp.css',
    ['depends' => [\yii\web\JqueryAsset::className()]]
  );
?>
<div class="panel">
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'roles'=>$roles,
            'supervisores'=>$supervisores
        ]) ?>
    </div>
</div>

<?php
$this->registerJs(
  '
  var claseOcultar = "hidden-xl-down";
  $("#entusuarios-txt_auth_item").on("change", function(){
    var val = $(this).val();
    var contenedor = $(".asignar-supervisor-contenedor");
    if(val=="'.Constantes::USUARIO_CALL_CENTER.'"){
      contenedor.removeClass(claseOcultar);
    }else{
      contenedor.addClass(claseOcultar);
    }

  });
  ',
  View::POS_END,
  'tipo-usuario'
);
?>