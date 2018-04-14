<?php

use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'Dashboard';

$this->registerCssFile(
    '@web/webAssets/templates/classic/topbar/assets/examples/css/charts/chartjs.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/templates/classic/global/vendor/chart-js/Chart.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>

<div class="panel-dashboard">

    <div class="row">
    




    <div class="col-md-4">
            <!-- Card -->
            <div class="panel">
                    <div class="panel-heading">
                        <h2 class="panel-title"></h2>
                    </div>
                    <div class="panel-body">
                        <canvas id="exampleChartjsDonut"></canvas>
                    </div>
            </div>
            <!-- End Card -->
        
        </div>

        <div class="col-lg-6">
            <!-- Card -->
            <div class="card card-block p-30">
                <div class="counter counter-md text-left">
                <div class="counter-label text-uppercase mb-5">Envios exitosos</div>
                <div class="counter-number-group mb-10">
                    <span class="counter-number">350</span>
                </div>
                <div class="counter-label">
                    <div class="progress progress-xs mb-5">
                    <div class="progress-bar progress-bar-info bg-green-600" aria-valuenow="20.3" aria-valuemin="0" aria-valuemax="100" style="width: 20.3%" role="progressbar">
                        <span class="sr-only">14%</span>
                    </div>
                    </div>
                    <div class="counter counter-sm text-left">
                    <div class="counter-number-group">
                        <span class="counter-icon green-600 mr-5"><i class="wb-graph-up"></i></span>
                        <span class="counter-number">14%</span>
                        <span class="counter-number-related">más que el mes pasado</span>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
      
    </div>

    <div class="row">
    <div class="col-md-4">
            <!-- Card -->
            <div class="card card-block p-30 bg-blue-600">
                <div class="card-watermark darker font-size-80 m-15"><i class="icon wb-clipboard" aria-hidden="true"></i></div>
                    <div class="counter counter-md counter-inverse text-left">
                        <div class="counter-number-group">
                            <span class="counter-number">345</span>
                            <span class="counter-number-related text-capitalize">Llamadas realizadas</span>
                        </div>
                    <div class="counter-label text-capitalize">esperando confirmación</div>
                </div>
            </div>
            <!-- End Card -->
        </div>
       
        <div class="col-md-4">
            <!-- Card -->
            <div class="card card-block p-30 bg-green-600">
                <div class="card-watermark darker font-size-60 m-15"><i class="icon pe-7s-headphones" aria-hidden="true"></i></div>
                <div class="counter counter-md counter-inverse text-left">
                <div class="counter-number-group">
                    <span class="counter-number">150</span>
                    <span class="counter-number-related text-capitalize">Citas autorizadas</span>
                </div>
                <div class="counter-label text-capitalize">esta semana</div>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>

    <!-- <button type="button" class="btn btn-floating btn-success"><i class="icon wb-pencil" aria-hidden="true"></i></button> -->

</div>

<?php 
$this->registerJs(
    '

    var doughnutData = {
      labels: [
        "Portabilidad",
        "Migración",
        "Línea nueva",

      ],
      datasets: [{
        data: [300, 50, 100],
        backgroundColor: [
            Config.colors("red", 400),
            Config.colors("green", 400),
            Config.colors("yellow", 400)
          ],
          hoverBackgroundColor: [
            Config.colors("red", 600),
            Config.colors("green", 600),
            Config.colors("yellow", 600)
          ]
  
      }]
    };

    var myDoughnut = new Chart(document.getElementById("exampleChartjsDonut").getContext("2d"), {
      type: "doughnut",
      data: doughnutData,
      options: {
        responsive: true
      }
    });
    ',
    View::POS_END,
    'my-button-handler'
);
