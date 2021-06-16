<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    //
    protected $table='categories';

    protected $fillable = [
        'name', 
    ];

     //Relation many to one
     public function products()
     {
         return $this->hasMany('App\Product');
     }
}
