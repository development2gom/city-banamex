<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_permisos_usuarios".
 *
 * @property integer $id_permiso_usuario
 * @property string $txt_auth_item
 * @property integer $id_accion
 * @property integer $id_status_cita
 *
 * @property AuthItem $txtAuthItem
 * @property CatAccionesCita $idAccion
 * @property CatStatusCitas $idStatusCita
 */
class EntPermisosUsuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_permisos_usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_accion', 'id_status_cita'], 'required'],
            [['id_accion', 'id_status_cita'], 'integer'],
            [['txt_auth_item'], 'string', 'max' => 64],
            [['txt_auth_item'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['txt_auth_item' => 'name']],
            [['id_accion'], 'exist', 'skipOnError' => true, 'targetClass' => CatAccionesCita::className(), 'targetAttribute' => ['id_accion' => 'id_accion_cita']],
            [['id_status_cita'], 'exist', 'skipOnError' => true, 'targetClass' => CatStatusCitas::className(), 'targetAttribute' => ['id_status_cita' => 'id_statu_cita']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_permiso_usuario' => 'Id Permiso Usuario',
            'txt_auth_item' => 'Txt Auth Item',
            'id_accion' => 'Id Accion',
            'id_status_cita' => 'Id Status Cita',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTxtAuthItem()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'txt_auth_item']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAccion()
    {
        return $this->hasOne(CatAccionesCita::className(), ['id_accion_cita' => 'id_accion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatusCita()
    {
        return $this->hasOne(CatStatusCitas::className(), ['id_statu_cita' => 'id_status_cita']);
    }
}
