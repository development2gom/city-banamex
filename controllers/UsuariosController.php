<?php

namespace app\controllers;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\ModUsuarios\models\Utils;
use app\models\AuthItem;
use app\models\Constantes;
use app\components\AccessControlExtend;
use yii\web\UploadedFile;

/**
 * UsuariosController implements the CRUD actions for EntUsuarios model.
 */
class UsuariosController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControlExtend::className(),
                'only' => ['index', 'create', 'update', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view'],
                    'allow' => true,
                        'roles' => [Constantes::USUARIO_SUPERVISOR, Constantes::USUARIO_SUPERVISOR_TELCEL],
                    ],
                    
                  
                ],
            ]
        ];
    }

    /**
     * Lists all EntUsuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $usuario = EntUsuarios::getUsuarioLogueado();

        $auth = Yii::$app->authManager;

        $hijos = $auth->getChildRoles($usuario->txt_auth_item);
        ksort($hijos);
       
        $roles = AuthItem::find()->where(['in', 'name', array_keys($hijos)])->orderBy("name")->all();

        $searchModel = new UsuariosSearch();
        $searchModel->txt_auth_item = array_keys($hijos);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Displays a single EntUsuarios model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EntUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $usuario = EntUsuarios::getIdentity();

        $auth = Yii::$app->authManager;

        $hijos = $auth->getChildRoles($usuario->txt_auth_item);
        ksort($hijos);
        $roles = AuthItem::find()->where(['in', 'name', array_keys($hijos)])->orderBy("name")->all();

        $supervisores = EntUsuarios::find()->where(['txt_auth_item'=>Constantes::USUARIO_SUPERVISOR])->orderBy("txt_username, txt_apellido_paterno")->all();

        $model = new EntUsuarios([
            'scenario' => 'registerInput'
        ]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {

                return $this->redirect(['index']);
            }
        
        // return $this->redirect(['view', 'id' => $model->id_usuario]);
        }
        return $this->render('create', [
            'model' => $model,
            'roles'=>$roles,
            'supervisores'=>$supervisores
        ]);
    }

    /**
     * Updates an existing EntUsuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $usuario = EntUsuarios::getIdentity();

        $auth = Yii::$app->authManager;

        $hijos = $auth->getChildRoles($usuario->txt_auth_item);
        ksort($hijos);
        $roles = AuthItem::find()->where(['in', 'name', array_keys($hijos)])->orderBy("name")->all();

        $supervisores = EntUsuarios::find()->where(['txt_auth_item'=>Constantes::USUARIO_SUPERVISOR])->orderBy("txt_username, txt_apellido_paterno")->all();

        $model = $this->findModel($id);
        $rol = $model->txt_auth_item;
        $model->scenario = "update";

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())){
            if(isset($_POST["EntUsuarios"]['password'])){
                $model->setPassword($_POST["EntUsuarios"]['password']);
                $model->generateAuthKey();
            }
            if($model->save()){

                $manager = Yii::$app->authManager;
                $item = $manager->getRole($rol);
                $item = $item ? : $manager->getPermission($rol);
                $manager->revoke($item,$model->id_usuario);

                $authorRole = $manager->getRole($model->txt_auth_item);
                $manager->assign($authorRole, $model->id_usuario);
                
                
                return $this->redirect(['index']);
            }
        }
        
        
        return $this->render('update', [
            'model' => $model,
            'roles'=>$roles,
            'supervisores'=>$supervisores
        ]);
        
    }

    public function actionTestRemover(){
        $manager = Yii::$app->authManager;
        $item = $manager->getRole(Constantes::USUARIO_ADMINISTRADOR_TELCEL);
        $item = $item ? : $manager->getPermission(Constantes::USUARIO_ADMINISTRADOR_TELCEL);
        $manager->revoke($item,194);

        $authorRole = $manager->getRole(Constantes::USUARIO_SUPERVISOR_TELCEL);
        $manager->assign($authorRole, 194);
    }

    /**
     * Deletes an existing EntUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EntUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EntUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntUsuarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

   

    public function actionImportarData(){

        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName('file-import');

            if ($file) {                
               
                try{
                    $inputFileType = \PHPExcel_IOFactory::identify($file->tempName);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($file);
                }catch(\Exception $e){

                }
            }
        }

        return $this->render("importar-data");
    }
}
