<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'personal';

    protected $primaryKey = 'IDENTIFICA';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IDENTIFICA',
        'TIPO_DOCUM',
        'NRO_DOCUME',
        'CUIL',
        'LEGAJO',
        'tipo_horario',
        'APELLIDOS',
        'NOMBRES'
     ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'FECHA_NACI',
        'FECHA_INGR',
        'FECHA_EGRE',
        'SEXO',
        'TELEFONO',
        'TELEFONO_C',
        'ID_LOCALID',
        'DOMICILIO',
        'TIPOCONTRA',
        'ID_SINDICA',
        'ID_OBRASOC',
        'ID_NACIONA',
        'ID_ESTADO_',
        'ID_ESTUDIO',
        'ID_EMPRESA',
        'ID_CATEGOR',
        'ID_MODALID',
        'ID_TIPOCON',
        'OBSERVACIO',
        'FOTO',
        'SLD_CAJA_T',
        'SLD_NRO_CA',
        'SLD_ID_BAN',
        'SLD_CBU',
        'MARCA_RELO',
        'IDAREAPROC'
    ];

}
