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
use app\models\ResponseServices;
use app\models\CatStatusCitasApi;
use yii\bootstrap\Html;
use yii\helpers\Url;
use app\models\Files;
use app\models\EntEvidenciasCitas;
use yii\web\UploadedFile;
use app\models\Calendario;
use app\models\CatCallsCenters;
use app\models\CatEquipos;

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
                'only' => ['create', 'index', 'view', 'actualizar-envio', 'upload-file'],
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'view','actualizar-envio', 'upload-file'],
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
        
        $statusCitas = CatStatusCitas::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        
        

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
            $equipo = CatEquipos::find()->where(["txt_nombre"=>$model->id_equipo])->one();
           
            $model->id_equipo = $equipo->id_equipo;
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
            $equipo = CatEquipos::find()->where(["txt_nombre"=>$model->id_equipo])->one();
           
            $model->id_equipo = $equipo->id_equipo;
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
        echo $cita->consultarEnvio("SSYBS01031800012");
    }

    public function actionVerStatusEnvio($token=null){

        $cita = new EntCitas();
        $envio = EntEnvios::find()->where(['txt_token'=>$token])->one();
        
        $envio->txt_respuesta_api = $cita->consultarEnvio($envio->txt_tracking);
        $respuestaApi = json_decode($envio->txt_respuesta_api);
        $envio->txt_historial_api = ($cita->consultarHistorico($envio->txt_tracking));
        $historico = json_decode($envio->txt_historial_api);
       

        if($cita->id_status==Constantes::STATUS_ENTREGADO){
            $envio->fch_entrega = $respuestaApi->Fecha;
            $envio->b_cerrado = 1;
        }
        
        $envio->save();
       
        return $this->render("ver-status-envio", ['envio'=>$envio, "respuestaApi"=>$respuestaApi, "historico"=>$historico]);
    }


    public function actionTestApiImage(){
        $tracking = "SSYBS15041800002";
        $cita = new EntCitas();
        $respuestaApi = ($cita->consultarEnvio($tracking));
        $historico =($cita->consultarHistorico($tracking));

echo $historico;
echo $respuestaApi;
exit;
        print_r($respuestaApi);

        print_r($historico);
        exit;
        
    }

    public function actionActualizarEnvio($envio){
        $response = new ResponseServices();
        if(!$envioSearch = EntEnvios::find()->where(["txt_tracking"=>$envio])->one()){
            $response->message = "No se encontro el envio en la base de datos";
            return $response;
        }
        $cita = $envioSearch->idCita;
        $envioSearch->txt_respuesta_api = $cita->consultarEnvio($envio);
        $respuestaApi = json_decode($envioSearch->txt_respuesta_api);

        if(!$statusApi = CatStatusCitas::find()->where(["txt_identificador_api"=>$respuestaApi->ClaveEvento])->one()){
            $response->message = "No se encontro el status del api en la base de datos";
            return $response;
        }


        $cita->id_status = $statusApi->id_statu_cita;

        if($cita->id_status==Constantes::STATUS_ENTREGADO){
            $envioSearch->fch_entrega = $respuestaApi->Fecha;
            $envioSearch->b_cerrado = 1;
        }
        $envioSearch->save();
        



        if(!$cita->save()){
            $response->message = "No se pudo guardar la cita";
            $response->result = $cita->errors;
            return $response;
        }

        $response->status = "success";
        $response->message = "Todo correcto";
        $statusColor = EntCitas::getColorStatus($cita->id_status);
        $response->result["a"] = Html::a(
            $statusApi->txt_nombre,
            Url::to(['citas/view', 'token' => $cita->txt_token]), 
            [
                'id'=>"js-cita-envio-".$cita->txt_token,
                'data-envio'=>$envio,
                'class'=>'btn badge '.$statusColor.' no-pjax actualizar-envio',
            ]
        );
        $response->result["token"] = $cita->txt_token;

        return $response;
    }

    public function actionUploadFile($token=null){
        $cita = EntCitas::find()->where(["txt_token"=>$token])->one();
        $evidencia = EntEvidenciasCitas::find()->where(["id_cita"=>$cita->id_cita])->one();

        if($evidencia){
            Files::borrarArchivo($evidencia->txt_url);
        }else{
            $evidencia = new EntEvidenciasCitas();
        }
        
        $response = new ResponseServices();

        $file = UploadedFile::getInstanceByName("file-upload");
        //$response->result = $file;

        if(!$file){
            $response->message = "Archivo nulo";
            return $response;
        }

        Files::validarDirectorio("evidencias/".$cita->txt_token);
        $namefile = uniqid("pdf").".".$file->extension;
        $path = "evidencias/".$cita->txt_token."/".$namefile;
        $isSaved = $file->saveAs($path);

        echo $isSaved;
        exit;
        if($isSaved){
           
            $evidencia->id_cita = $cita->id_cita;
            $evidencia->txt_url = $path;
            $evidencia->txt_nombre_original = $file->name;
            $evidencia->txt_token = Utils::generateToken("FIL");
            $evidencia->fch_creacion = Calendario::getFechaActual();
           
            if($evidencia->save()){
                $response->message = "Archivo guardado.";
                $response->status = "success";
                $response->result['url'] = Url::base()."/citas/descargar-evidencia?token=".$evidencia->txt_token;
            }else{
                $response->message="Ocurrio un problema al guardar en la base de datos.";
                Files::borrarArchivo($path);
            }
            
            
        }else{
            $response->message= "El archivo no se pudo guardar.";
        }

        return $response;
    }

    public function actionDescargarEvidencia($token=null){
        $evidencia = EntEvidenciasCitas::find(["txt_token"=>$token])->one();
        $cita = $evidencia->idCita;
        if (file_exists($evidencia->txt_url)) {
            Yii::$app->response->sendFile($evidencia->txt_url, "Evidencia_".$cita->txt_identificador_cliente.".pdf");
        }else{
            echo $evidencia->txt_url;
        }
        
    }



public function actionEnvios(){
    //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //$envios = EntEnvios::find()->select("txt_respuesta_api")->all();

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

    $items = Yii::$app->db->createCommand('select 
     EN.txt_historial_api
       from ent_citas C
    LEFT JOIN cat_tipos_tramites TT ON TT.id_tramite = C.id_tipo_tramite
    LEFT JOIN cat_equipos E ON E.id_equipo = C.id_equipo
    LEFT JOIN cat_areas A ON A.id_area = C.id_area
    LEFT JOIN mod_usuarios_ent_usuarios U ON U.id_usuario = C.id_usuario
    LEFT JOIN cat_status_citas SC ON SC.id_statu_cita = C.id_status
    LEFT JOIN cat_tipos_clientes TC ON TC.id_tipo_cliente = C.id_tipo_cliente
    LEFT JOIN cat_tipos_identificaciones TI ON TI.id_tipo_identificacion = C.id_tipo_identificacion
    LEFT JOIN ent_horarios_areas HA ON HA.id_horario_area = C.id_horario
    LEFT JOIN cat_cats CC ON CC.id_cat = C.id_cat
    LEFT JOIN ent_envios EN ON EN.id_envio = C.id_envio;
    
    
    ');
    
    $items = $items->query();
    

    foreach($items as $row) {
        fputcsv($output, $row);
    }

   
}

public function actionTestCrear(){
    Files::validarDirectorio("evidencias/test");
}
    
}
