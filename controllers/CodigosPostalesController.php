<?php

namespace app\controllers;

use Yii;
use app\models\CatCodigosPostales;
use app\models\CatCodigosPostalesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RelMunicipioCodigoPostal;
use app\models\RelMunicipioCodigoPostalSearch;

/**
 * CodigosPostalesController implements the CRUD actions for CatCodigosPostales model.
 */
class CodigosPostalesController extends Controller
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
     * Lists all CatCodigosPostales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatCodigosPostalesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatCodigosPostales model.
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
     * Creates a new CatCodigosPostales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatCodigosPostales();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->txt_codigo_postal]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatCodigosPostales model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->txt_codigo_postal]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CatCodigosPostales model.
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
     * Finds the CatCodigosPostales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CatCodigosPostales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatCodigosPostales::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBuscarCodigo($q=null, $page=0){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $criterios['txt_codigo_postal'] = $q;
        $searchModel = new RelMunicipioCodigoPostalSearch();

        if($page > 1){
            $page--;
        }
        $dataProvider = $searchModel->search($criterios, $page);
        $response['results']= null;
        $response['total_count'] = $dataProvider->getTotalCount();

        $resultados = $dataProvider->getModels();
        if(count($resultados)==0){
            $response['results'][0] = ['id'=>'', "txt_nombre"=>''];
        }

        foreach($resultados as $model){
            $response['results'][]=['id'=>$model->txt_codigo_postal, "txt_nombre"=>$model->txt_codigo_postal];
        }
    
        return $response;
    }

   
}
