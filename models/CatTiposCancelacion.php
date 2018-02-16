<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_cancelacion".
 *
 * @property string $id_tipo_cancelacion
 * @property string $txt_nombre
 * @property string $txt_tipo
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntCitas[] $entCitas
 */
class CatTiposCancelacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_cancelacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_tipo'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 100],
            [['txt_tipo'], 'string', 'max' => 64],
            [['txt_descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_cancelacion' => 'Id Tipo Cancelacion',
            'txt_nombre' => 'Txt Nombre',
            'txt_tipo' => 'Txt Tipo',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_tipo_cancelacion' => 'id_tipo_cancelacion']);
    }
}
