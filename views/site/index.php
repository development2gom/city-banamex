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
