<?php

// comment out the following two lines when deployed to production
 defined('YII_DEBUG') or define('YII_DEBUG', true);
 defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();

#supervisor-call-center-grupo2@bright-star.com
#supervisor11@bright-star.com
#call-center@bright-star.com
#call-center2@bright-star.com
#supervisor-telcel@bright-star.com
#administrador-telcel@bright-star.com