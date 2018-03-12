<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_status_citas_api".
 *
 * @property integer $id_status_cita_api
 * @property string $tx_nombre
 * @property string $txt_identificador_api
 * @property integer $b_habilitado
 *
 * @property CatStatusCitas[] $catStatusCitas
 */
class CatStatusCitasApi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_status_citas_api';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_habilitado'], 'integer'],
            [['tx_nombre', 'txt_identificador_api'], 'string', 'max' => 100],
            [['txt_identificador_api'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_status_cita_api' => 'Id Status Cita Api',
            'tx_nombre' => 'Tx Nombre',
            'txt_identificador_api' => 'Txt Identificador Api',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatStatusCitas()
    {
        return $this->hasMany(CatStatusCitas::className(), ['id_statu_cita_api' => 'id_status_cita_api']);
    }
}
