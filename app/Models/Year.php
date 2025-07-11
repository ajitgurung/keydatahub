<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Year extends EloquentModel
{
    protected $fillable = ['year', 'model_id'];

    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function info()
    {
        return $this->hasOne(Info::class);
    }
}
