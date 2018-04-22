<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="<?= Yii::$app->language ?>">
<!-- Etiqueta head -->
<?=$this->render("//components/head")?>
<body class="animsition body-bgkd <?=isset($this->params['classBody'])?$this->params['classBody']:''?>">
<input style="display:none" type="text" name="email"/>
Username <input type="text" name="nombreCompleto" >
<input style="display:none" type="password" name="fakepasswordremembered"/>
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <?php $this->beginBody();?>

  <!-- <div class="body-bgkd-mask"></div> -->
  
  <?=$this->render("//components/classic/topbar/nav-bar")?>

  <?=$this->render("//components/classic/topbar/menu")?>

  <?=$this->render("//components/classic/topbar/body", ['content'=>$content])?>

  <div style="position:absolute;height:0px; overflow:hidden; ">
  Username <input type="text" name="fake_safari_username" >
  
  Password <input type="password" name="fake_safari_password">
</div>

  <?=$this->render("//components/classic/topbar/footer")?>

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

  <?=isset($this->params['modal'])?$this->params['modal']:''?>
</body>
</html>
<?php $this->endPage() ?>
