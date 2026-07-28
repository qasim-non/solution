<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';


    protected $fillable = [
        'project_name',
        'mobile',
        'description'
    ];


    public function platforms()
    {
        return $this->hasMany();
    }

    public function system_types()
    {
        return $this->hasMany();
    }
}
