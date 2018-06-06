<?php

namespace app\controllers;

use Yii;
use app\models\CatCats;
use app\models\CatCatsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CatsController implements the CRUD actions for CatCats model.
 */
class CatsController extends Controller
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
     * Lists all CatCats models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatCatsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatCats model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CatCats model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatCats();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cat]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatCats model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cat]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CatCats model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CatCats model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatCats the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatCats::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionBuscarCat($equipo = null, $q = null, $page = 0)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $criterios['txt_nombre'] = $q;
        $searchModel = new CatCatsSearch();

        

        if ($page > 1) {
            $page--;
        }
        $searchModel->b_habilitado = 1;
        $dataProvider = $searchModel->searchCat($criterios, $page);
        $response['results'] = null;
        $response['total_count'] = $dataProvider->getTotalCount();

        $resultados = $dataProvider->getModels();
        if (count($resultados) == 0) {
            $response['results'][0] = ['id' => '', "txt_nombre" => ''];
        }

        foreach ($resultados as $model) {
           

            $response['results'][] = [
                'id' => $model->id_cat, 
                "txt_nombre" => $model->txt_nombre,
                "txt_estado"=>$model->txt_estado,
                "txt_calle_numero"=>$model->txt_calle_numero,
                "txt_colonia"=>$model->txt_colonia,
                "txt_codigo_postal"=>$model->txt_codigo_postal,
                "txt_municipio"=>$model->txt_municipio
            ];   
               
        }        

        return $response;
    }

    public function actionImportarData(){

        $errores = [];
        return $this->redirect(['site/construccion']);
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
}
