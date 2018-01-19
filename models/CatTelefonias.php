<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_telefonias".
 *
 * @property string $id_telefonia
 * @property string $txt_nombre
 * @property string $txt_descricpcion
 * @property string $b_habilitado
 */
class CatTelefonias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_telefonias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 100],
            [['txt_descricpcion'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_telefonia' => 'Id Telefonia',
            'txt_nombre' => 'Txt Nombre',
            'txt_descricpcion' => 'Txt Descricpcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }
}
