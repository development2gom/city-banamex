<?php

namespace app\models;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;

/**
 * This is the model class for table "ent_usuarios_bloqueados".
 *
 * @property integer $id_usuario_bloqueado
 * @property integer $id_usuario
 * @property string $fch_bloqueo
 * @property integer $num_intentos
 * @property integer $b_bloqueado
 *
 * @property EntUsuarios $idUsuario
 */
class EntUsuariosBloqueados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_usuarios_bloqueados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'fch_bloqueo'], 'required'],
            [['id_usuario', 'num_intentos', 'b_bloqueado'], 'integer'],
            [['fch_bloqueo'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_bloqueado' => 'Id Usuario Bloqueado',
            'id_usuario' => 'Id Usuario',
            'fch_bloqueo' => 'Fch Bloqueo',
            'num_intentos' => 'Num Intentos',
            'b_bloqueado' => 'B Bloqueado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(EntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }
}
