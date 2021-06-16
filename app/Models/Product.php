<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
     //Indica la tabla del modelo
     protected $table='products';

    //Indica los campos que serán editables
    protected $fillable=[
        'category_id',
        'cost',
        'stock',
        'priceTotal',
        'tax',
        'active',
        'description',
        'reference',
        'codebar',
        'user_id',
        'description_kardex',
    ];

//Relation many to one
public function user(){
    return $this->belongsTo('App\Models\User', 'user_id');
}

public function category(){
    return $this->belongsTo('App\Models\Category','category_id');
}

//Relation many to one
public function entry()
{
    return $this->hasMany('App\Models\InputProduct');
}

public function detail(){
    return $this->hasMany('App\Detail');
}

public function kardex(){
    return $this->hasMany('App\Models\Kardex');
}

}
