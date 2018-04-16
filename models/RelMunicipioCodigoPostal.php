<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_municipio_codigo_postal".
 *
 * @property integer $id_municipio
 * @property string $txt_codigo_postal
 *
 * @property CatMunicipios $idMunicipio
 * @property CatCodigosPostales $txtCodigoPostal
 */
class RelMunicipioCodigoPostal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_municipio_codigo_postal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_municipio', 'txt_codigo_postal'], 'required'],
            [['id_municipio'], 'integer'],
            [['txt_codigo_postal'], 'string', 'max' => 5],
            [['id_municipio'], 'exist', 'skipOnError' => true, 'targetClass' => CatMunicipios::className(), 'targetAttribute' => ['id_municipio' => 'id_municipio']],
            [['txt_codigo_postal'], 'exist', 'skipOnError' => true, 'targetClass' => CatCodigosPostales::className(), 'targetAttribute' => ['txt_codigo_postal' => 'txt_codigo_postal']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_municipio' => 'Id Municipio',
            'txt_codigo_postal' => 'Txt Codigo Postal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMunicipio()
    {
        return $this->hasOne(CatMunicipios::className(), ['id_municipio' => 'id_municipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTxtCodigoPostal()
    {
        return $this->hasOne(CatCodigosPostales::className(), ['txt_codigo_postal' => 'txt_codigo_postal']);
    }
}
