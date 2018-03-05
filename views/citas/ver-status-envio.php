<?php
// use yii\helpers\Url;
use app\models\Calendario;
$this->title = $envio->txt_tracking;
$this->params['classBody'] = "site-navbar-small site-menubar-hide";

$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-calendar"></i> Citas', 
    'url' => ['index'],
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false
];
$this->params['breadcrumbs'][] = [
    'label' => '<i class="icon wb-eye"></i> '.$envio->idCita->txt_identificador_cliente,
    'url'=>['view', 'token'=>$envio->idCita->txt_token],
    'template'=>'<li class="breadcrumb-item">{link}</li>', 
    'encode' => false];



?>

<div class="citas-status-send">

    <div class="row">
        <div class="col-md-4">

            <div class="citas-stat-send-grals">

                <h3>Datos Generales</h3>
                <div class="citas-stat-send-item">
                    <h5>Fecha</h5>
                    <p><?=Calendario::getDateComplete($respuestaApi->Fecha)?></p>
                </div>
                <div class="citas-stat-send-item">
                    <h5>Evento</h5>
                    <p><?=$respuestaApi->Evento?></p>
                </div>
                <div class="citas-stat-send-item">
                    <h5>Motivo de cancelación</h5>
                    <?php
                    if($respuestaApi->ClaveMotivo>0){
                        
                        echo "<p>".$respuestaApi->Motivo."</p>";
                    }
                    ?>
                    
                </div>
                <hr>
                <div class="citas-stat-send-item">
                    <h5>Mapa</h5>
                    <?php 
                        if($respuestaApi->Position){
                            
                            $coordenadas = explode("|" , $respuestaApi->Position);

                            $latitud = $coordenadas[1];
                            $longitud = $coordenadas[0];
                            ?>
                            <div class="card card-shadow">
                                <figure class="card-img-top overlay-hover overlay">
                                    <img class="overlay-figure overlay-scale" src="http://staticmap.openstreetmap.de/staticmap.php?center=<?=$latitud?>,<?=$longitud?>&zoom=19&size=500x350" alt="...">
                                    <!-- <figcaption class="overlay-panel overlay-background overlay-fade overlay-icon">
                                        <a class="icon wb-search" href="../../../global/photos/placeholder.png"></a>
                                    </figcaption> -->
                                </figure>
                            </div>
                        <?php
                        }else{
                            echo "Sin posición";
                        }
                        
                    ?>
                    
                </div>
                <div class="citas-stat-send-item">
                    <h5>Firma</h5>
                    <!-- <p><img class="avatar avatar-lg" src="<?=$respuestaApi->Image?>" /></p> -->

                    <div class="card card-shadow">
                        <figure class="card-img-top overlay-hover overlay">
                            <img class="overlay-figure overlay-scale" src="<?=$respuestaApi->Image?>" alt="...">
                            <!-- <figcaption class="overlay-panel overlay-background overlay-fade overlay-icon">
                                <a class="icon wb-search" href="../../../global/photos/placeholder.png"></a>
                            </figcaption> -->
                        </figure>
                    </div>

                </div>
                <div class="citas-stat-send-item">
                    <h5>Evidencias</h5>
                    <?php
                    if(isset($respuestaApi->ImagesLinks)){
                        foreach($respuestaApi->ImagesLinks as $images){
                            ?>
                            <div class="card card-shadow">
                                <figure class="card-img-top overlay-hover overlay">
                                    <img class="overlay-figure overlay-scale" src="<?=$images->Link?>" alt="...">
                                    <!-- <figcaption class="overlay-panel overlay-background overlay-fade overlay-icon">
                                        <a class="icon wb-search" href="../../../global/photos/placeholder.png"></a>
                                    </figcaption> -->
                                </figure>
                            </div>
                            <?php
                        }
                    }    
                    ?>
                </div>

            </div>

        </div>


        <div class="col-md-8">

            <div class="citas-stat-send-record">
            
                <div class="citas-stat-send-record-head">
                    <h3>Historial</h3>
                    <div class="panel-actions panel-actions-keep">
                        <a class="badge" href="<?=$respuestaApi->TrackingLink?>" target="_blank">Link</a>
                        <!-- <span class="badge badge-primary">Tag</span>
                        <span class="badge badge-pill badge-danger">Tag-pill</span> -->
                </div>
                </div>

                <div class="citas-stat-send-record-panel">
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Fecha & Hora</th>
                                <th>Motivo</th>
                                <th>Evidencia</th>
                                <th>Firma</th>
                                <th>Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($historico->History)){
                                    usort($historico->History, function($a, $b) { return strtotime($b->Fecha) - strtotime($a->Fecha); });
                                    foreach($historico->History as $historial){
                            ?>
                                <tr>
                                    <td>
                                        <div class="badge">
                                            <?=$historial->Evento?>
                                        </div>
                                    </td>
                                    <td>
                                        <span>
                                            <i class="wb wb-time"></i>
                                            <?=Calendario::getDateCompleteHour($historial->Fecha)?>  
                                        </span>
                                    </td>
                                    <td>
                                        <?=$historial->Motivo?>
                                    </td>
                                    <td>
                                        <!-- <img class="avatar avatar-sm" src="http://via.placeholder.com/200x200" data-toggle="tooltip" data-original-title="Crystal Bates" data-container="body" title=""> -->
                                    </td>
                                    <td>
                                        <!-- <img class="avatar avatar-sm" src="http://via.placeholder.com/200x200" data-toggle="tooltip" data-original-title="Crystal Bates" data-container="body" title=""> -->
                                        <img class="avatar avatar-sm" src="<?=$historial->Firma?>">
                                    </td>
                                    <td>
                                        <?=$historial->Comentario?>
                                    </td>
                                </tr>
                            <?php
                                }
                                }
                            ?>
                        </tbody>
                    </table>


                
                </div>
            
            </div>

        </div>
    </div>

</div>


<!--
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Información general
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
                <div class="col-md-3">
                    <h5>Fecha</h5>
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
                            
                            echo '<img style="width:100%" src="http://staticmap.openstreetmap.de/staticmap.php?center='.$latitud.','.$longitud.'&zoom=19&size=500x350"/>';
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
            <div class="col-md-3">
                <h5>Imagenes</h5>
                <?php
                if(isset($respuestaApi->ImagesLinks)){
                    foreach($respuestaApi->ImagesLinks as $images){
                        echo "<img src='".$images->Link."' style='width:100%' />";
                    }
                }    
                ?>
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
            usort($historico->History, function($a, $b) { return strtotime($b->Fecha) - strtotime($a->Fecha); });
           foreach($historico->History as $historial){
        ?>

        <div class="row">
            <div class="col-md-3">
                <h5>
                    Fecha    
                </h5>
                <p>
                    <?=Calendario::getDateCompleteHour($historial->Fecha)?>  
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
                <img style="width:100%" src="<?=$historial->Firma?>">
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
</div>-->
