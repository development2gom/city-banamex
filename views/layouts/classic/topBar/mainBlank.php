<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use app\assets\AppAssetClassicTopBarBlank;
use yii\helpers\Url;

AppAssetClassicTopBarBlank::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="<?= Yii::$app->language ?>">
<!-- Etiqueta head -->
<?=$this->render("//components/head")?>
<body class="animsition <?=isset($this->params['classBody'])?$this->params['classBody']:''?>">

  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <?php $this->beginBody();?>
  
  <div class="page-login-v3-mask"></div>
  <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="login-header">
      <img src="<?=Url::base()?>/webAssets/images/logo.png" alt="">
    </div>
    <div class="page-content vertical-align-middle animation-slide-top animation-duration-1 page-login">
      <?=$content?>
      
    </div>

    <?=$this->render("//components/classic/topbar/footerBlank")?>
  </div>  

  <?php $this->endBody();?>
  <script src="<?= Url::base() ?>/webAssets/templates/classic/global/vendor/breakpoints/breakpoints.js"></script>
    <script>
    Breakpoints();
    </script>
  <script>
  (function(document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
  </script>
</body>
</html>
<?php $this->endPage() ?>
