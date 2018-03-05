<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Calendario;
use app\modules\ModUsuarios\models\EntUsuarios;
use kop\y2sp\ScrollPager;
use app\components\LinkSorterExtends;
use yii\helpers\Url;
use sjaakp\alphapager\AlphaPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = [
  'label' => '<i class="icon pe-users"></i>'.$this->title, 
  'encode' => false,
  'template'=>'<li class="breadcrumb-item">{link}</li>', 
];

$this->params['headerActions'] = '<a class="btn btn-success" href="'.Url::base().'/usuarios/create"><i class="icon wb-plus"></i> Agregar usuario</a>';

$this->params['classBody'] = "site-navbar-small page-user";

$this->registerCssFile(
  '@web/webAssets/templates/classic/topbar/assets/examples/css/pages/user.css',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
  '@web/webAssets/templates/classic/global/js/Plugin/responsive-tabs.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
  '@web/webAssets/templates/classic/global/js/Plugin/tabs.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

?>

  <!-- <form class="page-search-form" role="search">
    <div class="input-search input-search-dark">
      <i class="input-search-icon wb-search" aria-hidden="true"></i>
      <input type="text" class="form-control" id="inputSearch" name="search" placeholder="Search Users">
      <button type="button" class="input-search-close icon wb-close" aria-label="Close"></button>
    </div>
  </form> -->
    
<!-- Panel -->
<div class="panel panel-list-user-table">

    <?=$this->render("_search", ['model'=>$searchModel])?>
      
    <?php
    $sort = "txt_username";
    if(isset($_GET['sort'])){
      $sort = substr($_GET['sort'], 0,1);
      if($sort=="-"){
        $sort = substr($_GET['sort'], 1);
      }else{
        $sort = $_GET['sort'];
      }
    }
    #exit;
    ?>
    
   
    <?php
    $atributoActivado = EntUsuarios::label()[$sort];
    // $sorter ='<div class="dropdown">
    //             Ordenar por: <a class="dropdown-toggle inline-block" data-toggle="dropdown"
    //             href="#" aria-expanded="false">'.$atributoActivado.'</a>
    //             {sorter}
    //           </div>';
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
          'class'=>"panel-table-int"
        ],
        'tableOptions' => [
          'class'=>"table table-hover"
        ],
        'layout' => '{items}{summary}{pager}',
        'columns' =>[
          [
            'attribute' => 'txt_username',
            'format'=>'raw',
            'contentOptions' => [
              'class'=>"flex"
            ],
            'value'=>function($data){
                
              return '<a href="'.Url::base().'/usuarios/update/'.$data->id_usuario.'"><img class="panel-listado-img" src="'.$data->imageProfile.'" alt="">
              <span>'.$data->nombreCompleto .'</span></a>';
            }
          ],
          'txtAuthItem.description',
          [
            'attribute' => 'fch_creacion',
            'format'=>'raw',
            // 'contentOptions' => [
            //   'class'=>"flex"
            // ],
            'value'=>function($data){
                
              return Calendario::getDateSimple($data->fch_creacion);
            }
          ],
          [
            'attribute' => 'id_status',
            'format'=>'raw',
            // 'contentOptions' => [
            //   'class'=>"flex"
            // ],
            'value'=>function($data){

            $activo = $data->id_status == 2?'active':'';
            $inactivo = $data->id_status == 1||$data->id_status == 3?'active':'';
                
              return '<div class="btn-group" data-toggle="buttons" role="group">
              <label class="btn btn-active '.$activo.'">
              <input data-token="'.$data->txt_token.'" type="radio" name="options" autocomplete="off" value="male" checked />
              Activo
              </label>
              <label class="btn btn-inactive '.$inactivo.'">
              <input data-token="'.$data->txt_token.'" type="radio" name="options" autocomplete="off" value="female" />
              Inactivo
              </label>
              </div>';
            }
          ],
          [
            'attribute' => 'Editar',
            'format'=>'raw',
            // 'contentOptions' => [
            //   'class'=>"flex"
            // ],
            'value'=>function($data){
                
              return '<a href="'.Url::base().'/usuarios/update/'.$data->id_usuario.'" class="btn btn-outline btn-success btn-sm"><i class="icon wb-plus"></i></a>';
            }
          ]
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
      
    ]);?>
    

</div>
<!-- End Panel -->
