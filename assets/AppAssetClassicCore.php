<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAssetClassicCore extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/webAssets/templates/classic/global/';
    
    public $css = [
        "css/bootstrap.min.css",
        "css/bootstrap-extend.min.css",
        // plugins
        "vendor/animsition/animsition.min.css",
        "vendor/asscrollable/asScrollable.min.css",
        "vendor/switchery/switchery.min.css",
        "vendor/intro-js/introjs.min.css",
        "vendor/slidepanel/slidePanel.min.css",
        'vendor/bootstrap-sweetalert/sweetalert.min.css',
        "vendor/flag-icon-css/flag-icon.min.css",
        // Fonts
        "fonts/web-icons/web-icons.min.css",
        "fonts/brand-icons/brand-icons.min.css",
        "fonts/7-stroke/7-stroke.min.css",
        'fonts/font-awesome/font-awesome.min.css',
        'fonts/stroke7/pe-icon-7-stroke-min.css',
        'fonts/octicons/octicons.min.css',
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic',
     
    ];
    public $js = [
        'vendor/babel-external-helpers/babel-external-helpers.js',
        #'vendor/jquery/jquery.js',
        'vendor/tether/tether.min.js',
        'vendor/bootstrap/bootstrap.min.js',
        'vendor/animsition/animsition.min.js',
        'vendor/mousewheel/jquery.mousewheel.min.js',
        'vendor/asscrollbar/jquery-asScrollbar.min.js',
        'vendor/asscrollable/jquery-asScrollable.min.js',
        'vendor/switchery/switchery.min.js',
        'vendor/intro-js/intro.min.js',
        'vendor/screenfull/screenfull.min.js',
        'vendor/slidepanel/jquery-slidePanel.min.js',
        'vendor/jquery-placeholder/jquery.placeholder.min.js',
        'vendor/bootstrap-sweetalert/sweetalert.min.js',
        'js/State.min.js',
        'js/Component.min.js',
        'js/Plugin.min.js',
        'js/Base.min.js',
        'js/Config.min.js',
        'js/config/colors.min.js',
        'js/Plugin/slidepanel.min.js',
        'js/Plugin/switchery.min.js',
        'js/Plugin/material.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
