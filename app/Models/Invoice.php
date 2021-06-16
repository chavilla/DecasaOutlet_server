<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
     //Indica la tabla del modelo
     protected $table='invoices';
     public $timestamps = false;

    protected $fillable=[
        'id',
        'user_id',
        'client_id',
        'ruc_client',
        'total',
        'payMode',
        'created_at'
    ];

    public function details()
    {
        return $this->hasMany('App\Detail');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

}
