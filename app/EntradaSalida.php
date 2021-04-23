<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntradaSalida extends Model
{
    //protected $connection = 'mysql_dev';
    public $table = 'entradasalida';
    public $timestamps  = false;
    protected $primaryKey = 'esId';


    protected $fillable = [
        'esId',
        'id',
        'fecha',
        'tipo'
    ];
}
