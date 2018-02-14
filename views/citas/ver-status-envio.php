<?php
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
                    <p><?=$respuestaApi->Fecha?></p>
                </div>
                <div class="col-md-3">
                    <h5>Imagen</h5>
                    <p><img src="<?=$respuestaApi->Image?>" /></p>
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
                            echo '<img style="width:100%" src="https://maps.googleapis.com/maps/api/staticmap?center='.$latitud.','.$longitud.'&markers=color:redC%7C'.$latitud.','.$longitud.'&zoom=19&size=600x400"/>';
                        }
                        
                    ?>
                    
                    
                </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?=$respuestaApi->Motivo?>
            </div>
            <div class="col-md-3">
                <?=$respuestaApi->TrackingLik?>
            </div>
        </div>
    </div>
</div>
