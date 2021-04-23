<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    public $table = 'metadata';
    public $timestamps = false;
    protected $primaryKey = 'metId';
    protected $casts = [
        'metCodigo' => 'integer',
    ];

 /*   protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];*/

    protected $fillable = [
        'metGroup',
        'metName',
        'metCodigo',
        'metOrder',
        'metIcon',
        'metColor',
        'metStatus'
    ];
}
