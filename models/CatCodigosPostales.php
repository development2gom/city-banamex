<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_codigos_postales".
 *
 * @property string $txt_codigo_postal
 *
 * @property RelMunicipioCodigoPostal[] $relMunicipioCodigoPostals
 * @property CatMunicipios[] $idMunicipios
 */
class CatCodigosPostales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_codigos_postales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_codigo_postal'], 'required'],
            [['txt_codigo_postal'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'txt_codigo_postal' => 'Txt Codigo Postal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelMunicipioCodigoPostals()
    {
        return $this->hasMany(RelMunicipioCodigoPostal::className(), ['txt_codigo_postal' => 'txt_codigo_postal']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMunicipios()
    {
        return $this->hasMany(CatMunicipios::className(), ['id_municipio' => 'id_municipio'])->viaTable('rel_municipio_codigo_postal', ['txt_codigo_postal' => 'txt_codigo_postal']);
    }
}
