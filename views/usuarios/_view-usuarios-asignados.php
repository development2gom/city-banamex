<?php

use app\models\UsuariosSearch;
use app\modules\ModUsuarios\models\EntUsuarios;
use yii\widgets\ListView;
use app\components\LinkSorterExtends;
use kop\y2sp\ScrollPager;
use sjaakp\alphapager\AlphaPager;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;
 $searchModel = new UsuariosSearch();
 
 $dataProvider = $searchModel->searchCallCenter(Yii::$app->request->queryParams);
?>

<div class="panel panel-usuarios-editar-listado">
    <div class="panel-heading">
        <h3 class="panel-title">
          Usuarios Asignado
        </h3>
    </div>
    <div class="panel-body">
   
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
    $sorter ='<div class="dropdown">
                Ordenar por: <a class="dropdown-toggle inline-block" data-toggle="dropdown"
                href="#" aria-expanded="false">'.$atributoActivado.'</a>
                {sorter}
              </div>';
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'viewParams' => ['supervisor' => $model],
        'itemView' => '_itemAsignacion',
        'itemOptions'=>[
          'tag'=>"li",
          'class'=>"list-group-item"
        ],
        'layout'=>$sorter.'<ul class="list-group">{items}</ul>{pager}',
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
</div>

<?php
$this->registerJs(
  '
  $(document).on({
    "click": function(e){
      e.preventDefault();
      var l = Ladda.create(this);
      l.start();
      var boton = $(this);
      var supervisor = boton.data("supervisor");
      var call = boton.data("call");
        
      $.ajax({
        url: "'.Url::base().'/usuarios/remover-usuario",
        method: "post",
        data: {
          supervisor : supervisor,
          call: call
        },
        success: function(resp){
          boton.removeClass("js-remover-asignacion");
          boton.removeClass("btn-danger");
          boton.addClass("js-asignacion");
          boton.addClass("btn-success");
          boton.find(".ladda-label").text("Asignar");
          l.stop();
          
        }
      });
    }
}, ".js-remover-asignacion");

$(document).on({
  "click": function(e){
    e.preventDefault();
    var boton = $(this);
    var supervisor = boton.data("supervisor");
    var call = boton.data("call");
    var l = Ladda.create(this);
    l.start();
    $.ajax({
      url: "'.Url::base().'/usuarios/asignar-usuario",
      method: "post",
      data: {
        supervisor : supervisor,
        call: call
      },
      success: function(resp){
        boton.addClass("js-remover-asignacion");
        boton.addClass("btn-danger");
        boton.removeClass("js-asignacion");
        boton.removeClass("btn-success");
        boton.find(".ladda-label").text("Remover");
        l.stop();
      }
    });
  }
}, ".js-asignacion");
  
  ',
  View::POS_END,
  'asignar-usuario'
  );