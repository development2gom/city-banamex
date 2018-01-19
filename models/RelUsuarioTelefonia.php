<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_usuario_telefonia".
 *
 * @property string $id_usuario
 * @property string $id_telefonia
 */
class RelUsuarioTelefonia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_usuario_telefonia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_telefonia'], 'required'],
            [['id_usuario', 'id_telefonia'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'id_telefonia' => 'Id Telefonia',
        ];
    }
}
