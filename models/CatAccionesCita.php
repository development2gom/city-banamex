<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_acciones_cita".
 *
 * @property integer $id_accion_cita
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilitado
 *
 * @property EntPermisosUsuarios[] $entPermisosUsuarios
 */
class CatAccionesCita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_acciones_cita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 200],
            [['txt_descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_accion_cita' => 'Id Accion Cita',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntPermisosUsuarios()
    {
        return $this->hasMany(EntPermisosUsuarios::className(), ['id_accion' => 'id_accion_cita']);
    }
}
