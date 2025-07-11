<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $fillable = ['name', 'make_id'];
    
    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    public function years()
    {
        return $this->hasMany(Year::class);
    }
}
