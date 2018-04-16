<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_calls_centers".
 *
 * @property integer $id_call_center
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property integer $b_habilitado
 *
 * @property EntCitas[] $entCitas
 * @property ModUsuariosEntUsuarios[] $modUsuariosEntUsuarios
 */
class CatCallsCenters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_calls_centers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 100],
            [['txt_descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_call_center' => 'Id Call Center',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_call_center' => 'id_call_center']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModUsuariosEntUsuarios()
    {
        return $this->hasMany(ModUsuariosEntUsuarios::className(), ['id_call_center' => 'id_call_center']);
    }
}
