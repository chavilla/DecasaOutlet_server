<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
     //Indica la tabla del modelo
     protected $table='details';

    //Indica los campos que serán editables
    protected $fillable=[
        'product_id',
        'invoice_id',
        'amount',
        'priceUnit',
        'priceTotal',
    ];

    public function invoice(){
        return $this->belongsTo('App\Models\invoice','invoice_id');
    }
    
    public function product(){
        return $this->belongsTo('App\Models\product','product_id');
    }

}
