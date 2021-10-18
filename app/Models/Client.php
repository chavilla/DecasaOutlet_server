<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
     //table
     protected $table = 'clients';

     protected $fillable = [
     'id',
     'ruc',
     'name',
     'lastName',
     'phone',
     'email',
     'active',
     ];
}
