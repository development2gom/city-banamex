<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */

$this->title = $model->id_cita;
$this->params['breadcrumbs'][] = ['label' => 'Ent Citas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-citas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_cita], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_cita], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_cita',
            'id_tipo_tramite',
            'id_equipo',
            'id_area',
            'id_tipo_entrega',
            'id_usuario',
            'id_status',
            'id_envio',
            'id_tipo_cliente',
            'id_tipo_identificacion',
            'id_horario',
            'txt_telefono',
            'txt_nombre',
            'txt_apellido_paterno',
            'txt_apellido_materno',
            'txt_rfc',
            'txt_numero_telefonico_nuevo',
            'txt_email:email',
            'txt_folio_identificacion',
            'fch_nacimiento',
            'num_dias_servicio',
            'txt_token',
            'txt_iccid',
            'txt_imei',
            'txt_numero_referencia',
            'txt_numero_referencia_2',
            'txt_numero_referencia_3',
            'txt_estado',
            'txt_calle_numero',
            'txt_colonia',
            'txt_codigo_postal',
            'txt_municipio',
            'txt_entre_calles',
            'txt_observaciones_punto_referencia',
            'txt_motivo_cancelacion_rechazo',
            'fch_cita',
            
            'fch_creacion',
        ],
    ]) ?>

</div>
