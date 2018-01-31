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
                    <h5>Clave evento</h5>
                    <p><?=$respuestaApi->ClaveEvento?></p>
                </div>
                <div class="col-md-3">
                    <h5>Evento</h5>
                    <p><?=$respuestaApi->Evento?></p>
                </div>
                <div class="col-md-3">
                    <h5>Posición</h5>
                    <p><?=$respuestaApi->Position?></p>
                </div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Visita 1
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <h5>Fecha 1</h5>
                <p>28-Ene-2018 13:45</p>
            </div>
            <div class="col-md-3">
                <h5>Nota 1</h5>
                <p>comentarios de la visita</p>
            </div>
            <div class="col-md-3">
                <h5>Excepcion 1</h5>
                <p>Cliente ausente</p>
            </div>
            <div class="col-md-3">
                <h5>Operador</h5>
                <p>Juan Peréz</p>
            </div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Visita 2
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <h5>Fecha 2</h5>
                <p>29-Ene-2018 14:45</p>
            </div>
            <div class="col-md-3">
                <h5>Nota 2</h5>
                <p>Comentarios de la visita</p>
            </div>
            <div class="col-md-3">
                <h5>Excepcion 2</h5>
                <p>Domicilio incorrecto</p>
            </div>
            <div class="col-md-3">
                <h5>Operador</h5>
                <p>Juan Peréz</p>
            </div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Visita 3
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <h5>Fecha 2</h5>
                <p>30-Ene-2018 16:53</p>
            </div>
            <div class="col-md-3">
                <h5>Nota 2</h5>
                <p>Comentarios de la visita</p>
            </div>
            <div class="col-md-3">
                <h5>Excepcion 3</h5>
                <p>Devolución</p>
            </div>
            <div class="col-md-3">
                <h5>Operador</h5>
                <p>Juan Peréz</p>
            </div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Devolución
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <h5>Fecha solicitud devolución</h5>
                <p>31-Ene-2018</p>
            </div>
            <div class="col-md-3">
                <h5>Motivo de devolución</h5>
                <p>Devolución</p>
            </div>
            
        </div>
    </div>
</div>