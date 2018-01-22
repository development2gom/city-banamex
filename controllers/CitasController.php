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

        $statusCitas = CatStatusCitas::find()->where(['b_habilitado'=>1])->all();

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

        $tiposTramites = CatTiposTramites::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        $tiposClientes = CatTiposClientes::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        $tiposIdentificaciones = CatTiposIdentificaciones::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        $areas = CatAreas::find()->where(['b_habilitado'=>1])->orderBy("txt_nombre")->all();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->fch_cita = Utils::changeFormatDateInput($model->fch_cita);
            $model->fch_nacimiento = Utils::changeFormatDateInput($model->fch_nacimiento);

            if($model->save()){
                EntHistorialCambiosCitas::guardarHistorial($model->id_cita, "Cita editada");
                return $this->redirect(['index']);
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
        
        $status = Constantes::STATUS_CREADA;
        $model = new EntCitas();
        $model->iniciarModelo($status, $idArea, $numServicios, $tipoEntrega);

        if ($model->load(Yii::$app->request->post())) {
            $model->fch_cita = Utils::changeFormatDateInput($model->fch_cita);
            $model->fch_nacimiento = Utils::changeFormatDateInput($model->fch_nacimiento);
            
            $model->fch_creacion = Utils::getFechaActual();

            if($model->validarEdicionCita() && $model->save()){
                EntHistorialCambiosCitas::guardarHistorial($model->id_cita, "Cita creada");
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

    
    public function actionAprobarCitaSupervisor($token=null){
        $model = EntCitas::find()->where(['txt_token'=>$token])->one();
        
        EntHistorialCambiosCitas::guardarHistorial($model->id_cita, "Cita aprobada por supervisor");
        if($model->id_status==Constantes::STATUS_CREADA){
            $model->id_status = Constantes::STATUS_AUTORIZADA_POR_SUPERVISOR;
            if($model->save()){
                $this->redirect(["index"]);
            } 
        }else{
            $this->redirect(['view', 'token'=>$token]);
        }
    }
    
}
