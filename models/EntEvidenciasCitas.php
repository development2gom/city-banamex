<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_evidencias_citas".
 *
 * @property integer $id_evidencia_cita
 * @property integer $id_cita
 * @property string $txt_url
 * @property string $fch_creacion
 *
 * @property EntCitas $idCita
 */
class EntEvidenciasCitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_evidencias_citas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cita', 'txt_url', 'fch_creacion'], 'required'],
            [['id_cita'], 'integer'],
            [['txt_url'], 'string'],
            [['fch_creacion'], 'safe'],
            [['id_cita'], 'exist', 'skipOnError' => true, 'targetClass' => EntCitas::className(), 'targetAttribute' => ['id_cita' => 'id_cita']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_evidencia_cita' => 'Id Evidencia Cita',
            'id_cita' => 'Id Cita',
            'txt_url' => 'Txt Url',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCita()
    {
        return $this->hasOne(EntCitas::className(), ['id_cita' => 'id_cita']);
    }
}
