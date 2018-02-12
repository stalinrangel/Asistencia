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
    protected $fillable = ['IDENTIFICA',   'TIPO_DOCUM',  'NRO_DOCUME',  'CUIL',    'LEGAJO',  'APELLIDOS',   'NOMBRES' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}
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
    protected $fillable = ['IDENTIFICA',   'TIPO_DOCUM',  'NRO_DOCUME',  'CUIL',    'LEGAJO',  'APELLIDOS',   'NOMBRES' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}
