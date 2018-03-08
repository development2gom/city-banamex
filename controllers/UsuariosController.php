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
use app\models\EntGruposTrabajo;
use app\models\EntCitas;
use app\models\ResponseServices;
use app\models\CatCallsCenters;

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
                'only' => ['index', 'create', 'update', 'view', 'activar-usuario', 'bloquear-usuario'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'activar-usuario', 'bloquear-usuario'],
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
            'roles'=>$roles
            
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
        $roles = AuthItem::find()->where(['in', 'name', array_keys($hijos)])->orderBy("description")->all();

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

        $callCenters = CatCallsCenters::find()->all();
        return $this->render('create', [
            'model' => $model,
            'roles'=>$roles,
            'supervisores'=>$supervisores,
            'callCenters'=>$callCenters
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
            if($model->password){
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
        
        $callCenters = CatCallsCenters::find()->all();
        return $this->render('update', [
            'model' => $model,
            'roles'=>$roles,
            'supervisores'=>$supervisores,
            'callCenters'=>$callCenters
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

    public function actionBloquearUsuario($token=null){
        $respuesta = new ResponseServices();

        $usuario = $this->findModel(['txt_token'=>$token]);

        $usuario->id_status = EntUsuarios::STATUS_BLOCKED;
        if($usuario->save()){
            $respuesta->status = "success";
            $respuesta->message= "Usuario bloqeado";
        }else{
            $respuesta->status = "error";
            $respuesta->message = "No se pudo bloquear al usuario";
            $respuesta->result = $usuario->errors;
        }
        return $respuesta;
    }

    public function actionActivarUsuario($token=null){
        $respuesta = new ResponseServices();

        $usuario = $this->findModel(['txt_token'=>$token]);

        $usuario->id_status = EntUsuarios::STATUS_ACTIVED;
        if($usuario->save()){
            $respuesta->status = "success";
            $respuesta->message= "Usuario activado";
        }else{
            $respuesta->status = "error";
            $respuesta->message = "No se pudo activar al usuario";
            $respuesta->result = $usuario->errors;
        }

        return $respuesta;
    }

    public function actionImportarData(){

        $errores = [];
        
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName('file-import');
            
            if ($file) {                
               
                try{
                    $inputFileType = \PHPExcel_IOFactory::identify($file->tempName);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($file->tempName);
                }catch(\Exception $e){
                    echo $e;
                    exit;
                }

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                //  Loop through each row of the worksheet in turn
                for ($row = 2; $row <= $highestRow; $row++){ 
                    //  Read a row of data into an array
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                    NULL,
                                                    TRUE,
                                                    FALSE);
                    $usuario = new EntUsuarios(["scenario"=>"registerInput"]);                                
                    foreach($rowData as $data){
                       
                         $usuario->txt_username = $data[0];
                         $usuario->txt_apellido_paterno = $data[1];
                         $usuario->txt_email = $data[2];
                         $usuario->password = $data[3];
                         $usuario->repeatPassword = $data[3];
                         $usuario->setTipoUsuarioExcel($data[4]);
                    }
                    $usuario->signup();

                    if($usuario->errors){
                        echo "Problema en la fila ".$row.":<br>";
                        foreach($usuario->errors as $key=>$errores){
                            foreach($errores as $error){
                                if($key!="repeatPassword"){
                                    echo EntUsuarios::label()[$key]." ".$error."<br>";
                                }
                            }

                        }
                    }

                    //  Insert row data array into your database of choice here
                }

            }
        }

        return $this->render("importar-data", ['errores'=>$errores]);
    }


    public function actionAsignarUsuario(){

        if($_POST['supervisor'] && $_POST['call']){
            $supervisor = $_POST['supervisor'];
            $call = $_POST['call'];

            $asignacion = EntGruposTrabajo::find()->where(['id_usuario'=>$supervisor, 'id_usuario_asignado'=>$call])->one();

            if(!$asignacion){
                $asignacion = new EntGruposTrabajo();
                $asignacion->id_usuario = $supervisor;
                $asignacion->id_usuario_asignado = $call;
                $asignacion->save();
            }
        }
    }

    public function actionRemoverUsuario(){

        if($_POST['supervisor'] && $_POST['call']){
            $supervisor = $_POST['supervisor'];
            $call = $_POST['call'];

            $asignacion = EntGruposTrabajo::find()->where(['id_usuario'=>$supervisor, 'id_usuario_asignado'=>$call])->one();

            if($asignacion){
                
                $asignacion->delete();
            }
        }
    }

    public function actionTest(){
        $usuario = EntUsuarios::getIdentity();

        $auth = Yii::$app->authManager;

        $hijos = $auth->getChildRoles($usuario->txt_auth_item);
        ksort($hijos);
        print_r($hijos);
    }

}
