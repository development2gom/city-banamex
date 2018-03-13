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
            $model->id_call_center = $usuario->id_call_center;
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

        $respuestaApi = $cita->consultarEnvio($envio->txt_tracking);
        $historico = $cita->consultarHistorico($envio->txt_tracking);

        $envio->txt_respuesta_api = $respuestaApi;
        $envio->txt_historial_api = $historico;
        $envio->save();

        $respuestaApi = json_decode($respuestaApi);
        $historico = json_decode($historico);

       
       
        return $this->render("ver-status-envio", ['envio'=>$envio, "respuestaApi"=>$respuestaApi, "historico"=>$historico]);
    }


    public function actionTestApiImage(){
        $tracking = "SSYBS05031800002";
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

        $respuestaApi = json_decode($cita->consultarEnvio($envio));

        if(!$statusApi = CatStatusCitas::find()->where(["txt_identificador_api"=>$respuestaApi->ClaveEvento])->one()){
            $response->message = "No se encontro el status del api en la base de datos";
            return $response;
        }

        
        $cita->id_status = $statusApi->id_statu_cita;
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
                'class'=>'btn badge '.$statusColor.' no-pjax ',
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
                for ($row = 3; $row <= $highestRow; $row++){ 
                    $cita = new EntCitas();
                    //  Read a row of data into an array
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                    NULL,
                                                    TRUE,
                                                    FALSE);
                                            
                    foreach($rowData as $data){
                        $cita->id_tipo_tramite;
                        $cita->id_equipo;
                        $cita->id_area;
                        $cita->id_tipo_entrega;
                        $cita->id_usuario;
                        $cita->id_status;
                        $cita->id_tipo_cliente;
                        $cita->id_tipo_identificacion;
                        $cita->id_horario;
                        $cita->id_cat;
                        $cita->id_call_center;
                        $cita->txt_telefono;
                        $cita->txt_nombre;
                        $cita->txt_apellido_materno;
                        $cita->txt_apellido_paterno;
                        $cita->txt_email;
                        $cita->txt_folio_identificacion;
                        $cita->fch_nacimiento;
                        $cita->num_dias_servicio;
                        $cita->txt_token;
                        $cita->txt_iccid;
                        $cita->txt_imei;
                        $cita->txt_estado;
                        $cita->txt_calle_numero;
                        $cita->txt_colonia;
                        $cita->txt_codigo_postal;
                        $cita->txt_municipio;
                        $cita->txt_entre_calles;
                        $cita->txt_observaciones_punto_referencia;
                        $cita->txt_identificador_cliente;
                        $cita->txt_tpv;
                        $cita->txt_promocional;
                        $cita->fch_cita;
                        $cita->fch_creacion;
                        $cita->b_entrega_cat;
                        
                        
                    }
                  
                    $cita->save();
                   
                    //  Insert row data array into your database of choice here
                }

            }
        }

        return $this->render("importar-data", ['errores'=>$errores]);
    }

    public function getStatus($texto){
        switch ($texto) {
            case 'AUTORIZADO ADMINISTRADOR TELCEL':
            # code...
            break;
            case 'AUTORIZADO SUPERVISOR CALLCENTER':
            # code...
            break;
            case 'AUTORIZADO SUPERVISOR TELCEL':
            # code...
            break;
            case 'CANCELADO ADMINISTRADOR TELCEL':
            # code...
            break;
            case 'CAPTURA':
            # code...
            break;
            case 'RECHAZADO ADMINISTRADOR TELCEL':
            # code...
            break;
            case 'RECHAZADO SUPERVISOR TELCEL':
            # code...
            break;    
            
            default:
                
            break;
        }
    }

    
}
