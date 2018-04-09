<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\AccessControlExtend;
use app\models\EntEnvios;
use app\modules\ModUsuarios\models\Utils;
use yii\db\Expression;
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControlExtend::className(),
                 'only' => ['index', 'logout'],
                 'rules' => [
                     [
                         'actions' => ['logout', 'index'],
                     'allow' => true,
                         'roles' => ['@'],
                     ],
                     
                   
                 ],
             ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionTest(){
         //$auth = Yii::$app->authManager;
    
        //  // add "updatePost" permission
        //  $updatePost = $auth->createPermission('about');
        //  $updatePost->description = 'Update post';
        //  $auth->add($updatePost);
        //         // add "admin" role and give this role the "updatePost" permission
        // // as well as the permissions of the "author" role
        // $admin = $auth->createRole('test');
         //$auth->add($admin);
        // $auth->addChild($admin, $updatePost);
        
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $hoy = Utils::getFechaActual();

        $citasEntregadas = (new \yii\db\Query())
        ->select(['E.fch_entrega'])
        ->from('ent_citas C')
        ->join('INNER JOIN', 'ent_horarios_areas HA', 'HA.id_horario_area = C.id_horario')
        ->join('INNER JOIN', 'ent_envios E', 'C.id_envio = E.id_envio AND E.b_cerrado = 1 AND TIME_FORMAT(E.fch_entrega, "%H" ) BETWEEN TIME_FORMAT(HA.txt_hora_inicial, "%H" ) AND TIME_FORMAT(HA.txt_hora_final, "%H" )')
        ->all();

        $envios = EntEnvios::find()
            ->where(['>=','fch_entrega', new Expression("curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY") ])
            ->andWhere(['<','fch_entrega', new Expression("curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY") ])
            ->all();
        $numeroEnvios = count($envios);
        $numeroEnviosExitosos = count($citasEntregadas);
       // $citasAutorizadas = EntCitas::find()->where()->all();
        return $this->render('index', ["numeroEnvios"=>$numeroEnvios, "numeroEnviosExitosos"=>$numeroEnviosExitosos]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionConstruccion(){

        $this->layout = "classic/topBar/mainBlank";

        return $this->render("construccion");
    }

    

    public function actionGetcontrollersandactions()
    {
        $controllerlist = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        $fulllist = [];
        foreach ($controllerlist as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fulllist[strtolower(substr($controller, 0, -14))][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;

        print_r($fulllist);
        exit;
        return $fulllist;
    }
}
