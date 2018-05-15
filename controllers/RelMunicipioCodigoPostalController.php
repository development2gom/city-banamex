<?php

namespace app\controllers;

use Yii;
use app\models\RelMunicipioCodigoPostal;
use app\models\RelMunicipioCodigoPostalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ResponseServices;
use app\models\Calendario;
use app\models\EntCitas;
use app\modules\ModUsuarios\models\Utils;
use app\models\CatCats;

/**
 * RelMunicipioCodigoPostalController implements the CRUD actions for RelMunicipioCodigoPostal model.
 */
class RelMunicipioCodigoPostalController extends Controller
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
     * Lists all RelMunicipioCodigoPostal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RelMunicipioCodigoPostalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RelMunicipioCodigoPostal model.
     * @param integer $id_municipio
     * @param string $txt_codigo_postal
     * @return mixed
     */
    public function actionView($id_municipio, $txt_codigo_postal)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_municipio, $txt_codigo_postal),
        ]);
    }

    /**
     * Creates a new RelMunicipioCodigoPostal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RelMunicipioCodigoPostal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_municipio' => $model->id_municipio, 'txt_codigo_postal' => $model->txt_codigo_postal]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RelMunicipioCodigoPostal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id_municipio
     * @param string $txt_codigo_postal
     * @return mixed
     */
    public function actionUpdate($id_municipio, $txt_codigo_postal)
    {
        $model = $this->findModel($id_municipio, $txt_codigo_postal);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_municipio' => $model->id_municipio, 'txt_codigo_postal' => $model->txt_codigo_postal]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RelMunicipioCodigoPostal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id_municipio
     * @param string $txt_codigo_postal
     * @return mixed
     */
    public function actionDelete($id_municipio, $txt_codigo_postal)
    {
        $this->findModel($id_municipio, $txt_codigo_postal)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RelMunicipioCodigoPostal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id_municipio
     * @param string $txt_codigo_postal
     * @return RelMunicipioCodigoPostal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_municipio, $txt_codigo_postal)
    {
        if (($model = RelMunicipioCodigoPostal::findOne(['id_municipio' => $id_municipio, 'txt_codigo_postal' => $txt_codigo_postal])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBuscarMunicipioCp($cp=null){
        $respuesta = new ResponseServices();

        if(!$cp){
            $respuesta->status = "success";
            $respuesta->message = "municipio";
            $respuesta->result["id_area"] = "";
            $respuesta->result["txt_area"] = "";
            $respuesta->result["txt_municipio"] = "";
            $respuesta->result["num_dias_servicios"] = "";
        }

        
        $rel = RelMunicipioCodigoPostal::find()->where(["txt_codigo_postal"=>$cp])->one();
        $municipio = $rel->idMunicipio;
        $diasServicio = $this->getDiasServicio($municipio);
        $diasServicioNum = $this->getDiasServicioNum($municipio);
        $area = $municipio->idArea;

        $fechaInicio= EntCitas::getFechaEntrega(Utils::getFechaActual());
        $fechaInicio= Utils::changeFormatDate($fechaInicio);


        $startDate = $fechaInicio;
        $end = date('Y-m-d', strtotime('+2 months'));
        $end = Utils::changeFormatDate($end);

        $respuesta->status = "success";
        $respuesta->message = "municipio";
        $respuesta->result["id_area"] = $area->id_area;
        $respuesta->result["txt_area"] = $area->txt_nombre;
        $respuesta->result["txt_municipio"] = $municipio->txt_nombre;
        $respuesta->result["text_dias_servicios"] = $diasServicio;
        $respuesta->result["num_dias_servicios"] = $diasServicioNum;
        $respuesta->result["fch_inicio"] = $fechaInicio;
        $respuesta->result["fch_final"] = $end;
        
        return $respuesta;

    }

    public function actionBuscarCac($cp=null, $cac=null){
        $respuesta = new ResponseServices();

        if(!$cp){
            $respuesta->status = "success";
            $respuesta->message = "municipio";
            $respuesta->result["id_area"] = "";
            $respuesta->result["txt_area"] = "";
            $respuesta->result["txt_municipio"] = "";
            $respuesta->result["num_dias_servicios"] = "";
        }

        
        $rel = RelMunicipioCodigoPostal::find()->where(["txt_codigo_postal"=>$cp])->one();
        $municipio = $rel->idMunicipio;

        $c = CatCats::find()->where(["id_cat"=>$cac])->one();

        $diasServicio = $this->getDiasServicio($c);
        $diasServicioNum = $this->getDiasServicioNum($c);
        $area = $municipio->idArea;

        $fechaInicio= EntCitas::getFechaEntrega(Utils::getFechaActual());
        $fechaInicio= Utils::changeFormatDate($fechaInicio);


        $startDate = $fechaInicio;
        $end = date('Y-m-d', strtotime('+2 months'));
        $end = Utils::changeFormatDate($end);

        $respuesta->status = "success";
        $respuesta->message = "municipio";
        $respuesta->result["id_area"] = $area->id_area;
        $respuesta->result["txt_area"] = $area->txt_nombre;
        $respuesta->result["txt_municipio"] = $municipio->txt_nombre;
        $respuesta->result["text_dias_servicios"] = $diasServicio;
        $respuesta->result["num_dias_servicios"] = $diasServicioNum;
        $respuesta->result["fch_inicio"] = $fechaInicio;
        $respuesta->result["fch_final"] = $end;
        
        return $respuesta;

    }

    public function getDiasServicio($municipio){

        $l = $municipio->b_lunes?'L,':'';
        $m = $municipio->b_martes?'M,':'';
        $mi = $municipio->b_miercoles?'Mi,':'';
        $j = $municipio->b_jueves?'J,':'';
        $v = $municipio->b_viernes?'V,':'';
        $s = $municipio->b_sabado?'S,':'';
        $d = $municipio->b_domingo?'D,':'';

        $dias = $l.$m.$mi.$j.$v.$s.$d;
        return $dias;


    }

    public function getDiasServicioNum($municipio){

        $l = !$municipio->b_lunes?'1,':'';
        $m = !$municipio->b_martes?'2,':'';
        $mi = !$municipio->b_miercoles?'3,':'';
        $j = !$municipio->b_jueves?'4,':'';
        $v = !$municipio->b_viernes?'5,':'';
        $s = !$municipio->b_sabado?'6,':'';
        $d = !$municipio->b_domingo?'0,':'';

        $dias = $l.$m.$mi.$j.$v.$s.$d;
        return $dias;


    }
}
