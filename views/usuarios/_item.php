<?php
use app\models\Calendario;
use yii\helpers\Html;
use yii\helpers\Url;
?>


<td class="flex">
    <img class="panel-listado-img" src="<?=$model->imageProfile?>" alt="">
    <span><?= $model->nombreCompleto ?></span>
</td>
<td>
    <?=$model->txtAuthItem->description?>
</td>
<td>
    - Konecta -
</td>
<td>
    <?=Calendario::getDateComplete($model->fch_creacion)?>
</td>
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
<td>
    <button type="button" class="btn btn-outline btn-success btn-sm"><i class="icon wb-plus"></i></button>
</td>

<!-- <div class="media">
    <div class="pr-20">
        <div class="avatar avatar-online">
        <img src="<?=$model->imageProfile?>" alt="...">
        <i class="avatar avatar-busy"></i>
        </div>
    </div>
    <div class="media-body">
        <h5 class="mt-0 mb-5">
            <?= Html::a($model->nombreCompleto, ['usuarios/update/'.$model->id_usuario])?>
            <small><?=$model->txtAuthItem->description?></small>
        </h5>
        <p>
            <i class="icon icon-color wb-envelope" aria-hidden="true"></i>
            <?=$model->txt_email?>
        </p>
        <p>
            <i class="icon icon-color wb-calendar" aria-hidden="true"></i>
            <?=Calendario::getDateComplete($model->fch_creacion)?>
        </p>
        <div>
        
        </div>
    </div>
    <div class="pl-20 align-self-center">
        <a href="<?=Url::base()?>/usuarios/update/<?=$model->id_usuario?>" class="btn btn-success btn-sm">Editar</a>
    </div>
</div> -->
