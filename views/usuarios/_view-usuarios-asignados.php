<?php

use app\models\UsuariosSearch;
use app\modules\ModUsuarios\models\EntUsuarios;
use kartik\grid\GridView;
use app\components\LinkSorterExtends;
use kop\y2sp\ScrollPager;
use sjaakp\alphapager\AlphaPager;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;
use kartik\date\DatePicker;
use app\models\Calendario;
use yii\helpers\ArrayHelper;
use app\models\EntGruposTrabajo;
 $searchModel = new UsuariosSearch();
 
 $dataProvider = $searchModel->searchCallCenter(Yii::$app->request->queryParams);
?>

<div class="panel panel-usuarios-editar-listado">
    <h3 class="panel-title">
      Usuarios Asignado
    </h3>

   
    <?php
   echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'=>$searchModel,
    'options' => [
      'class'=>"panel-usuarios-editar-listado-body"
    ],
    'responsive'=>true,
    'striped'=>false,
    'hover'=>false,
    'bordered'=>false,
    'pjax'=>true,
    'pjaxSettings'=>[
      'options'=>[
        'linkSelector'=>"a:not(.no-pjax)"
      ]
    ],
    'tableOptions' => [
      'class'=>"table table-hover"
    ],
    'layout' => '{items}{summary}{pager}',
    'columns' =>[
      [
        'attribute' => 'nombreCompleto',
        
        'format'=>'raw',
        'contentOptions' => [
          'class'=>"flex"
        ],
        'value'=>function($data){
            
          return '<a class="no-pjax" href="'.Url::base().'/usuarios/update/'.$data->id_usuario.'"><img class="panel-listado-img" src="'.$data->imageProfile.'" alt="">
          <span>'.$data->nombreCompleto .'</span></a>';
        }
      ],
      [
        'attribute' => 'roleDescription',
        'filter'=>ArrayHelper::map($roles, 'name', 'description'),
      ],
      
      [
        'attribute' => 'fch_creacion',
        'filter'=>DatePicker::widget([
          'model'=>$searchModel,
          'attribute'=>'fch_creacion',
          'pickerButton'=>false,
          'removeButton'=>false,
          'type' => DatePicker::TYPE_INPUT,
          'pluginOptions' => [
              'autoclose'=>true,
              'format' => 'dd-mm-yyyy'
          ]
        ]),
        'format'=>'raw',
        'value'=>function($data){
            
          return Calendario::getDateSimple($data->fch_creacion);
        }
      ],
      [
        'label' => 'Asignacion',
        'filter'=>false,
        'format'=>'raw',
        
        'value'=>function($data) use ($model){
          
          $usuarioAsignado = EntGruposTrabajo::find()->where(['id_usuario'=>$model->id_usuario, 'id_usuario_asignado'=>$model->id_usuario])->one();
        $activo = $data->id_status == 2?'active':'';
        $inactivo = $data->id_status == 1||$data->id_status == 3?'active':'';
            
            if($usuarioAsignado){
              return '
              <a data-call="'.$data->id_usuario.'" 
                  data-supervisor="'.$model->id_usuario.'" href="'.Url::base().'/usuarios/update/'.$data->id_usuario.'" 
                  class="btn btn-danger btn-sm ladda-button js-remover-asignacion"
                  data-style="zoom-in">
                  <span class="ladda-label">
                      Remover
                  </span>
                  
              </a>
          ';
          }else{
            return '
              <a data-call="'.$data->id_usuario.'" 
                  data-supervisor="'.$model->id_usuario.'" href="'.Url::base().'/usuarios/update/'.$data->id_usuario.'" 
                  class="btn btn-success btn-sm ladda-button js-asignacion"
                  data-style="zoom-in">
                  <span>
                  Asignar
                  </span>
              </a>';
          
          }
        }
      ],
      [
        'attribute' => 'Editar',
        'format'=>'raw',
       
        'value'=>function($data){
            
          return '<a href="'.Url::base().'/usuarios/update/'.$data->id_usuario.'" class="btn btn-outline btn-success btn-sm"><i class="icon wb-edit"></i></a>';
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