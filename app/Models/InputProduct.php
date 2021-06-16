<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class InputProduct extends Model
{
    //
    use Notifiable;

     //table
     protected $table = 'inputs';

    protected $fillable = [
        'id',
        'amount',
        'cost',
        'product_id',
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
