<?php
use app\models\Calendario;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\EntGruposTrabajo;
?>
<div class="media">
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
        <?php
        $usuarioAsignado = EntGruposTrabajo::find()->where(['id_usuario'=>$supervisor->id_usuario, 'id_usuario_asignado'=>$model->id_usuario])->one();
        ?>

        <?php
        if($usuarioAsignado){?>
            <a data-call="<?=$model->id_usuario?>" 
                data-supervisor="<?=$supervisor->id_usuario?>" href="<?=Url::base()?>/usuarios/update/<?=$model->id_usuario?>" 
                class="btn btn-danger btn-sm ladda-button js-remover-asignacion"
                data-style="zoom-in">
                <span class="ladda-label">
                    Remover
                </span>
                
            </a>
        <?php
        }else{?>
            <a data-call="<?=$model->id_usuario?>" 
                data-supervisor="<?=$supervisor->id_usuario?>" href="<?=Url::base()?>/usuarios/update/<?=$model->id_usuario?>" 
                class="btn btn-success btn-sm ladda-button js-asignacion"
                data-style="zoom-in">
                <span>
                Asignar
                </span>
            </a>
        <?php
        }
        ?>
        
        
        <a href="<?=Url::base()?>/usuarios/update/<?=$model->id_usuario?>" class="btn btn-primary btn-sm">Editar</a>
    </div>
</div>
