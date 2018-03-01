<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use app\modules\ModUsuarios\models\EntUsuarios;
use kop\y2sp\ScrollPager;
use app\components\LinkSorterExtends;
use yii\helpers\Url;
use sjaakp\alphapager\AlphaPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Usuarios';
// $this->params['breadcrumbs'][] = [
//   'label' => '<i class="icon pe-users"></i>'.$this->title, 
//   'encode' => false,
//   'template'=>'<li class="breadcrumb-item">{link}</li>', 
// ];

// $this->params['headerActions'] = '<a class="btn btn-success" href="'.Url::base().'/usuarios/create"><i class="icon wb-plus"></i> Agregar usuario</a>';

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


<!-- Panel -->
<div class="panel panel-gral panel-list-user-table">
  <div class="panel-body">

    <div class="panel-search">
      <h3 class="panel-search-title">Usuarios</h3>
      <div class="panel-search-int">
        <form class="panel-search-form">
          <input type="text" class="panel-search-form-input" placeholder="Buscar por nombre o correo">
          <input type="text" class="panel-search-form-select" placeholder="Tipo">
        </form>
        <a class="btn btn-success btn-add" href="<?= Url::base()?>/usuarios/create"><i class="icon wb-plus"></i> Agregar usuario</a>
      </div>
        
    </div>

    <table class="table table-hover">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Tipo de usuario</th>
          <th>Cliente</th>
          <th>Último acceso</th>
          <th>Estatus</th>
          <th>Editar</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="flex">
            <img class="panel-listado-img" src="<?=EntUsuarios::getUsuarioLogueado()->imageProfile?>" alt=""> <span>Paulina Rivas</span>
          </td>
          <td>Ejecutivo Call-Center</td>
          <td>Konecta</td>
          <td>18 - Feb - 2017</td>
          <td>
            <div class="btn-group" data-toggle="buttons" role="group">
              <label class="btn btn-active active">
              <input type="radio" name="options" autocomplete="off" value="male" checked />
              Activo
              </label>
              <label class="btn btn-inactive">
              <input type="radio" name="options" autocomplete="off" value="female" />
              Inactivo
              </label>
            </div>
          </td>
          <td><button type="button" class="btn btn-outline btn-success btn-sm"><i class="icon wb-plus"></i></button></td>
        </tr>
        <tr>
          <td class="flex">
            <img class="panel-listado-img" src="<?=EntUsuarios::getUsuarioLogueado()->imageProfile?>" alt=""> <span>Paulina Rivas</span>
          </td>
          <td>Ejecutivo Call-Center</td>
          <td>Konecta</td>
          <td>18 - Feb - 2017</td>
          <td>
            <div class="btn-group" data-toggle="buttons" role="group">
              <label class="btn btn-active">
              <input type="radio" name="options" autocomplete="off" value="male" checked />
              Activo
              </label>
              <label class="btn btn-inactive active">
              <input type="radio" name="options" autocomplete="off" value="female" />
              Inactivo
              </label>
            </div>
          </td>
          <td><button type="button" class="btn btn-outline btn-success btn-sm"><i class="icon wb-plus"></i></button></td>
        </tr>
      </tbody>
    </table>    
  </div>
</div>
<!-- End Panel -->

    <!-- <form class="page-search-form" role="search">
      <div class="input-search input-search-dark">
        <i class="input-search-icon wb-search" aria-hidden="true"></i>
        <input type="text" class="form-control" id="inputSearch" name="search" placeholder="Search Users">
        <button type="button" class="input-search-close icon wb-close" aria-label="Close"></button>
      </div>
    </form> -->
    
<!-- Panel -->
<div class="panel panel-gral panel-list-user-table">


    <div class="panel-search">
      <h3 class="panel-search-title">Usuarios</h3>
      <div class="panel-search-int">
        <form class="panel-search-form">
          <input type="text" class="panel-search-form-input" placeholder="Buscar por nombre o correo">
          <input type="text" class="panel-search-form-select" placeholder="Tipo">
        </form>
        <a class="btn btn-success btn-add" href="<?= Url::base()?>/usuarios/create"><i class="icon wb-plus"></i> Agregar usuario</a>
      </div>
        
    </div>

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
        $atributoActivado = EntUsuarios::label()[$sort];
        // $sorter ='<div class="dropdown">
        //             Ordenar por: <a class="dropdown-toggle inline-block" data-toggle="dropdown"
        //             href="#" aria-expanded="false">'.$atributoActivado.'</a>
        //             {sorter}
        //           </div>';
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'itemOptions'=>[
              'tag'=>"li",
              'class'=>"list-group-item"
            ],
            // 'layout'=>$sorter.'<ul class="list-group">{items}</ul>{pager}',
            'layout'=>'<ul class="list-group">{items}</ul>{pager}',
            'sorter'=>[
              'class'=>LinkSorterExtends::className(),
              'attributes'=>[
                'txt_username',
                'txt_apellido_paterno',
                'txt_apellido_materno',
                'txt_email',
                'fch_creacion',
                
              ],
              'options'=>[
                'class'=>"dropdown-menu animation-scale-up animation-top-right animation-duration-250",
                'role'=>"menu"
              ],
              'linkOptions'=>[
                "class"=>"dropdown-item"
              ]
            ],
            'pager' => [
              'item'=>".list-group-item",
              'class' => ScrollPager::className(),
              'triggerText'=>'Cargar más datos',
              'noneLeftText'=>'No hay datos por cargar',
              'triggerOffset'=>999999999999999999999999999999999999999,
              'negativeMargin'=>5000,
              'enabledExtensions' => [
                  ScrollPager::EXTENSION_TRIGGER,
                  ScrollPager::EXTENSION_SPINNER,
                  ScrollPager::EXTENSION_NONE_LEFT,
                  ScrollPager::EXTENSION_PAGING,
              ],
              // ScrollPager::EXTENSION_SPINNER,
              // ScrollPager::EXTENSION_PAGING,
          ]
            
        ]);?>

</div>
<!-- End Panel -->
