<?php

namespace app\controllers;

use Yii;
use app\models\EntCitas;
use app\models\EntCitasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CatStatusCitas;
use app\models\CatTiposTramites;
use app\models\CatTiposClientes;
use app\models\CatTiposIdentificaciones;
use app\models\CatAreas;
use app\modules\ModUsuarios\models\Utils;
use app\modules\ModUsuarios\models\EntUsuarios;
use app\models\Constantes;
use app\models\EntHistorialCambiosCitas;
use yii\data\ActiveDataProvider;
use app\components\AccessControlExtend;
use app\models\H2H;
use app\models\EntEnvios;

/**
 * CitasController implements the CRUD actions for EntCitas model.
 */
class CitasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControlExtend::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                    'allow' => true,
                        'roles' => [Constantes::USUARIO_CALL_CENTER],
                    ],
                    
                  
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EntCitas models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ((\Yii::$app->user->can(Constantes::USUARIO_SUPERVISOR_TELCEL)) ){
            $statusCitas = CatStatusCitas::find()->where(['in', 'id_statu_cita', [
                Constantes::STATUS_AUTORIZADA_POR_SUPERVISOR, 
                Constantes::STATUS_AUTORIZADA_POR_ADMINISTRADOR_CC,
                Constantes::STATUS_AUTORIZADA_POR_SUPERVISOR_TELCEL, 
                Constantes::STATUS_AUTORIZADA_POR_ADMINISTRADOR_TELCEL,
                Constantes::STATUS_CANCELADA_ADMINISTRADOR_TELCEL,
                Constantes::STATUS_CANCELADA_SUPERVISOR_TELCEL 

            ]])->all();
        }else{
            $statusCitas = CatStatusCitas::find()->where(['b_habilitado'=>1])->all();
        }
        

        $searchModel = new EntCitasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status'=>$statusCitas,
        ]);
    }

    /**
     * Displays a single EntCitas model.
     * @param string $id
     * @return mixed
     */
    public function actionView($token)
    {

        $areaDefault = CatAreas::findOne(1); 
        $idArea = $areaDefault->id_area;
        $numServicios = $areaDefault->txt_dias_servicio;
        $tipoEntrega = 1;

        $model = EntCitas::find()->where(['txt_token'=>$token])->one();
        $model->scenario = "autorizar-update";

        $tiposTramites = CatTiposTramites::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        $tiposClientes = CatTiposClientes::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        $tiposIdentificaciones = CatTiposIdentificaciones::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        $areas = CatAreas::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->fch_cita = Utils::changeFormatDateInput($model->fch_cita);
            
             $model->fch_nacimiento = Utils::changeFormatDateInput($model->fch_nacimiento);
            
            $model->setAddresCat();
           
            if($model->isEdicion){
                if($model->save()){
                    $model->guardarHistorialUpdate();
                    return $this->redirect(['index']);
                }

            }else{
                if(\Yii::$app->user->can(Constantes::USUARIO_SUPERVISOR) ){
                    $model->statusAprobacionDependiendoUsuario();
                    if(\Yii::$app->user->can(Constantes::USUARIO_ADMINISTRADOR_TELCEL)){      
                        $model->generarNumeroEnvio();
                    } 
                    if($model->save()){
                        $model->guardarHistorialDependiendoUsuario();
                        
                        return $this->redirect(['index']);
                    } 
                }
            }

        } 
        
        $model->fch_cita = Utils::changeFormatDate($model->fch_cita);
        $model->fch_nacimiento = Utils::changeFormatDate($model->fch_nacimiento);

        $historialCambios = $model->getEntHistorialCambiosCitas();

        $dataProvider = new ActiveDataProvider([
            'query' => $historialCambios
        ]);

        return $this->render('view', [
            'model' => $model,
            'tiposTramites'=>$tiposTramites,
            'tiposClientes'=>$tiposClientes,
            'tiposIdentificaciones'=>$tiposIdentificaciones,
            'areas'=>$areas,
            'areaDefault'=>$areaDefault,
            'historial'=>$dataProvider
        ]);
    }

    

    /**
     * Creates a new EntCitas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $areaDefault = CatAreas::findOne(1); 
        $idArea = $areaDefault->id_area;
        $numServicios = $areaDefault->txt_dias_servicio;
        $tipoEntrega = 1;
        
        $usuario = EntUsuarios::getUsuarioLogueado();
        
        $model = new EntCitas(['scenario'=>'create-call-center']);

        if(\Yii::$app->user->can(Constantes::USUARIO_SUPERVISOR)){
            $model = new EntCitas(['scenario'=>'autorizar']);
        }
        $model->iniciarModelo($idArea, $numServicios, $tipoEntrega);

        if ($model->load(Yii::$app->request->post())) {

            if($model->id_equipo==Constantes::SIN_EQUIPO){
                $model->b_documentos = 1;
            }

            $model->fch_cita = Utils::changeFormatDateInput($model->fch_cita);
            $model->fch_nacimiento = Utils::changeFormatDateInput($model->fch_nacimiento);
            
            $model->fch_creacion = Utils::getFechaActual();
            $model->getConsecutivo();
            $model->statusAprobacionDependiendoUsuario();
            $model->setAddresCat();
            if($model->save()){

                if(\Yii::$app->user->can(Constantes::USUARIO_ADMINISTRADOR_TELCEL)){      
                    $model->generarNumeroEnvio();
                } 
                if($model->save()){
                    
                } 

                $model->guardarHistorialDependiendoUsuario(true);
                
                return $this->redirect(['index']);
            }   

            $model->fch_cita = Utils::changeFormatDate($model->fch_cita);
            $model->fch_nacimiento = Utils::changeFormatDate($model->fch_nacimiento);
        } 

        $tiposTramites = CatTiposTramites::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        $tiposClientes = CatTiposClientes::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        $tiposIdentificaciones = CatTiposIdentificaciones::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        $areas = CatAreas::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
       

        $model->fch_cita = EntCitas::getFechaEntrega(Utils::getFechaActual());
        $model->fch_cita = Utils::changeFormatDate($model->fch_cita);

        return $this->render('create', [
            'model' => $model,
            'tiposTramites'=>$tiposTramites,
            'tiposClientes'=>$tiposClientes,
            'tiposIdentificaciones'=>$tiposIdentificaciones,
            'areas'=>$areas,
            'areaDefault'=>$areaDefault
        ]);
        
    }

    /**
     * Updates an existing EntCitas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cita]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EntCitas model.
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
     * Finds the EntCitas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EntCitas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntCitas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionCancelar($token=null){
        $model = EntCitas::find()->where(['txt_token'=>$token])->one();

        
        $model->statusCancelarDependiendoUsuario();
        if($model->save()){
            $model->guardarHistorialDependiendoUsuario(false, true);
            $this->redirect(["index"]);
        } 
       
    }

    public function actionValidarTelefono($tel=null){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $respuesta["status"] = "success";
        $respuesta["mensaje"] = "Teléfono disponible";
        $respuesta["tel"] = $tel;

        $telefonoDisponible = EntCitas::find()
            ->where(['txt_telefono'=>$tel])
            ->andWhere(['in', 'id_status', [
                Constantes::STATUS_CREADA,
                Constantes::STATUS_AUTORIZADA_POR_ADMINISTRADOR_CC,
                Constantes::STATUS_AUTORIZADA_POR_SUPERVISOR
                ]])
            ->all();

        if($telefonoDisponible){
            $respuesta["status"] = "error";
            $respuesta["mensaje"] = "Teléfono no esta disponible";
        }
        

        return $respuesta;

    }

    public function actionTestApi(){
        $apiEnvio = new H2H();
        $cita = EntCitas::find()->one();
        $respuestaApi =  $apiEnvio->crearEnvio($cita);
        echo $respuestaApi;
    }

    public function actionConsultar(){
        $cita = new EntCitas();
        echo $cita->consultarEnvio("SSYR30011800003");
    }

    public function actionVerStatusEnvio($token=null){

        $cita = new EntCitas();
        $envio = EntEnvios::find()->where(['txt_token'=>$token])->one();
        $respuestaApi = json_decode($cita->consultarEnvio($envio->txt_tracking));
        $historico = json_decode($cita->consultarHistorico($envio->txt_tracking));

       
        return $this->render("ver-status-envio", ['envio'=>$envio, "respuestaApi"=>$respuestaApi, "historico"=>$historico]);
    }

    
}
