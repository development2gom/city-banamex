<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_horarios".
 *
 * @property string $id_horario
 * @property string $txt_horario_inicial
 * @property string $txt_horario_final
 * @property string $b_habilitado
 *
 * @property EntCitas[] $entCitas
 */
class CatHorarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_horarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_horario_inicial', 'txt_horario_final'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_horario_inicial', 'txt_horario_final'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_horario' => 'Id Horario',
            'txt_horario_inicial' => 'Txt Horario Inicial',
            'txt_horario_final' => 'Txt Horario Final',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_horario' => 'id_horario']);
    }
}
