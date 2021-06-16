<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    //
    protected $table = 'kardexes';

    // attributes
    protected $fillable = [
        'product_id',
        'description',
        'cost_pp',
        'input_amount',
        'input_value',
        'output_amount',
        'output_value',
        'balance_amount',
        'balance_value',
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
