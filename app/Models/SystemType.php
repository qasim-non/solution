<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemType extends Model
{
    protected $table = 'system_types';


    protected $fillable = [
        'name'
    ];

}
