<?php

namespace app\models;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;

/**
 * This is the model class for table "ent_grupos_trabajo".
 *
 * @property string $id_usuario
 * @property string $id_usuario_asignado
 *
 * @property ModUsuariosEntUsuarios $idUsuario
 * @property ModUsuariosEntUsuarios $idUsuarioAsignado
 */
class EntGruposTrabajo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_grupos_trabajo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_usuario_asignado'], 'required'],
            [['id_usuario', 'id_usuario_asignado'], 'integer'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_usuario_asignado'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario_asignado' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'id_usuario_asignado' => 'Id Usuario Asignado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(EntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuarioAsignado()
    {
        return $this->hasOne(EntUsuarios::className(), ['id_usuario' => 'id_usuario_asignado']);
    }
}
