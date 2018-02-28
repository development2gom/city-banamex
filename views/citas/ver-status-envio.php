<?php

use app\models\Calendario;
$this->title = 'Estatus del envio: '.$envio->txt_tracking;
$this->params['classBody'] = "site-navbar-small site-menubar-hide";

$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-calendar"></i> Citas', 
    'url' => ['index'],
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false
];
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-eye"></i> Cita '.$envio->idCita->txt_identificador_cliente,
    'url'=>['view', 'token'=>$envio->idCita->txt_token],
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false];
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-eye"></i> '.$this->title,
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false];


?>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Información general
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
                <div class="col-md-3">
                    <h5>Fecha api</h5>
                    <p><?=Calendario::getDateComplete($respuestaApi->Fecha)?></p>
                </div>
                <div class="col-md-3">
                    <h5>Imagen</h5>
                    <p><img style="width:100%" src="<?=$respuestaApi->Image?>" /></p>
                </div>
                <div class="col-md-3">
                    <h5>Evento</h5>
                    <p><?=$respuestaApi->Evento?></p>
                </div>
                <div class="col-md-3">
                    <h5>Posición</h5>
                    <?php 
                        if($respuestaApi->Position){
                            
                            $coordenadas = explode("|" , $respuestaApi->Position);

                            $latitud = $coordenadas[1];
                            $longitud = $coordenadas[0];
                            
                            echo '<img style="width:100%" src="http://staticmap.openstreetmap.de/staticmap.php?center='.$latitud.','.$longitud.'&markers=C%7C'.$latitud.','.$longitud.'&zoom=19&size=500x350"/>';
                        }else{
                            echo "Sin posición";
                        }
                        
                    ?>
                    
                </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <h5>Motivo de cancelación</h5>
                <?php
                if($respuestaApi->ClaveMotivo>0){
                    
                    echo "<p>".$respuestaApi->Motivo."</p>";
                }
                ?>
                
            </div>
            <div class="col-md-3">
                <h5>Link cliente</h5>
                <p><a href="<?=$respuestaApi->TrackingLink?>" target="_blank">Link</a></p>
            </div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Historial
        </h3>
    </div>
    <div class="panel-body">
        <?php
        if(isset($historico->History)){
           foreach($historico->History as $historial){
        ?>

        <div class="row">
            <div class="col-md-3">
                <h5>
                    Fecha    
                </h5>
                <p>
                    <?=Calendario::getDateComplete($historial->Fecha)?>  
                </p>
            </div>
            <div class="col-md-3">
                <h5>
                    Evento    
                </h5>
                <?=$historial->Evento?>
            </div>
            <div class="col-md-3">
                <h5>
                    Comentario
                </h5>
                <?=$historial->Comentario?>
            </div>
            <div class="col-md-3">
                <h5>
                    Firma
                </h5>
                <?=$historial->Firma?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <h5>
                    Motivo
                </h5>
                <p><?=$historial->Motivo?></p>
            </div>
        </div>

        <?php
            }
        }
        ?>
    </div>
</div>
