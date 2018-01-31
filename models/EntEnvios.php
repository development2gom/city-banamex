<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_envios".
 *
 * @property string $id_envio
 * @property string $id_cita
 * @property string $txt_tracking
 * @property string $txt_token
 *
 * @property EntCitas[] $entCitas
 * @property EntCitas $idCita
 */
class EntEnvios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_envios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cita', 'txt_tracking', 'txt_token'], 'required'],
            [['id_cita'], 'integer'],
            [['txt_tracking'], 'string', 'max' => 50],
            [['txt_token'], 'string', 'max' => 100],
            [['txt_token'], 'unique'],
            [['txt_tracking'], 'unique'],
            [['id_cita'], 'exist', 'skipOnError' => true, 'targetClass' => EntCitas::className(), 'targetAttribute' => ['id_cita' => 'id_cita']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_envio' => 'Id Envio',
            'id_cita' => 'Id Cita',
            'txt_tracking' => 'Txt Tracking',
            'txt_token' => 'Txt Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCita()
    {
        return $this->hasOne(EntCitas::className(), ['id_cita' => 'id_cita']);
    }
}
