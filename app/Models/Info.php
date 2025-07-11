<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $fillable = ['year_id', 'info', 'image'];
    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
