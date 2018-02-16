<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_cats".
 *
 * @property integer $id_cat
 * @property string $txt_nombre
 * @property string $txt_estado
 * @property string $txt_calle_numero
 * @property string $txt_colonia
 * @property string $txt_codigo_postal
 * @property string $txt_municipio
 * @property integer $b_habilitado
 *
 * @property EntCitas[] $entCitas
 */
class CatCats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_estado', 'txt_calle_numero', 'txt_colonia', 'txt_municipio'], 'string', 'max' => 100],
            [['txt_codigo_postal'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cat' => 'Id Cat',
            'txt_nombre' => 'Txt Nombre',
            'txt_estado' => 'Txt Estado',
            'txt_calle_numero' => 'Txt Calle Numero',
            'txt_colonia' => 'Txt Colonia',
            'txt_codigo_postal' => 'Txt Codigo Postal',
            'txt_municipio' => 'Txt Municipio',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_cat' => 'id_cat']);
    }
}
