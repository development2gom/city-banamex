<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_municipios".
 *
 * @property integer $id_municipio
 * @property string $txt_nombre
 * @property integer $id_tipo
 * @property integer $id_area
 * @property integer $b_lunes
 * @property integer $b_martes
 * @property integer $b_miercoles
 * @property integer $b_jueves
 * @property integer $b_viernes
 * @property integer $b_sabado
 * @property integer $b_domingo
 *
 * @property CatAreas $idArea
 * @property CatTipoEnvio $idTipo
 * @property EntCitas[] $entCitas
 * @property RelMunicipioCodigoPostal[] $relMunicipioCodigoPostals
 * @property CatCodigosPostales[] $txtCodigoPostals
 */
class CatMunicipios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_municipios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo', 'id_area', 'b_lunes', 'b_martes', 'b_miercoles', 'b_jueves', 'b_viernes', 'b_sabado', 'b_domingo'], 'integer'],
            [['id_area'], 'required'],
            [['txt_nombre'], 'string', 'max' => 100],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => CatAreas::className(), 'targetAttribute' => ['id_area' => 'id_area']],
            [['id_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => CatTipoEnvio::className(), 'targetAttribute' => ['id_tipo' => 'id_tipo_envio']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_municipio' => 'Id Municipio',
            'txt_nombre' => 'Txt Nombre',
            'id_tipo' => 'Id Tipo',
            'id_area' => 'Id Area',
            'b_lunes' => 'B Lunes',
            'b_martes' => 'B Martes',
            'b_miercoles' => 'B Miercoles',
            'b_jueves' => 'B Jueves',
            'b_viernes' => 'B Viernes',
            'b_sabado' => 'B Sabado',
            'b_domingo' => 'B Domingo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(CatAreas::className(), ['id_area' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipo()
    {
        return $this->hasOne(CatTipoEnvio::className(), ['id_tipo_envio' => 'id_tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCitas()
    {
        return $this->hasMany(EntCitas::className(), ['id_municipio' => 'id_municipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelMunicipioCodigoPostals()
    {
        return $this->hasMany(RelMunicipioCodigoPostal::className(), ['id_municipio' => 'id_municipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTxtCodigoPostals()
    {
        return $this->hasMany(CatCodigosPostales::className(), ['txt_codigo_postal' => 'txt_codigo_postal'])->viaTable('rel_municipio_codigo_postal', ['id_municipio' => 'id_municipio']);
    }

    public function getDiasServicio(){

        $l = $this->b_lunes?'L,':'';
        $m = $this->b_martes?'M,':'';
        $mi = $this->b_miercoles?'Mi,':'';
        $j = $this->b_jueves?'J,':'';
        $v = $this->b_viernes?'V,':'';
        $s = $this->b_sabado?'S,':'';
        $d = $this->b_domingo?'D,':'';

        $dias = $l.$m.$mi.$j.$v.$s.$d;
        return $dias;


    }
}
