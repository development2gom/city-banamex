<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatCats;

/**
 * CatCatsSearch represents the model behind the search form about `app\models\CatCats`.
 */
class CatCatsSearch extends CatCats
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cat', 'b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_estado', 'txt_calle_numero', 'txt_colonia', 'txt_codigo_postal', 'txt_municipio'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function searchCat($params, $page=0){
        
        $query = CatCats::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
                'page' => $page
            ],
            'sort' => [
                'defaultOrder' => [
                    'txt_nombre' => SORT_DESC,
                ]
            ],
        ]);

        $this->attributes =$params;


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_cat' => $this->id_cat,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_estado', $this->txt_estado])
            ->andFilterWhere(['like', 'txt_calle_numero', $this->txt_calle_numero])
            ->andFilterWhere(['like', 'txt_colonia', $this->txt_colonia])
            ->andFilterWhere(['like', 'txt_codigo_postal', $this->txt_codigo_postal])
            ->andFilterWhere(['like', 'txt_municipio', $this->txt_municipio]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CatCats::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_cat' => $this->id_cat,
            'b_habilitado' => $this->b_habilitado,
        ]);

        $query->andFilterWhere(['like', 'txt_nombre', $this->txt_nombre])
            ->andFilterWhere(['like', 'txt_estado', $this->txt_estado])
            ->andFilterWhere(['like', 'txt_calle_numero', $this->txt_calle_numero])
            ->andFilterWhere(['like', 'txt_colonia', $this->txt_colonia])
            ->andFilterWhere(['like', 'txt_codigo_postal', $this->txt_codigo_postal])
            ->andFilterWhere(['like', 'txt_municipio', $this->txt_municipio]);

        return $dataProvider;
    }
}
