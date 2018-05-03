<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipo_envio".
 *
 * @property integer $id_tipo_envio
 * @property string $txt_nombre
 * @property integer $b_habilitado
 *
 * @property CatMunicipios[] $catMunicipios
 */
class CatTipoEnvio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipo_envio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_envio' => 'Id Tipo Envio',
            'txt_nombre' => 'Txt Nombre',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatMunicipios()
    {
        return $this->hasMany(CatMunicipios::className(), ['id_tipo' => 'id_tipo_envio']);
    }
}
