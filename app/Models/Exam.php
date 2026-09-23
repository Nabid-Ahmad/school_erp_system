<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'description'];

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
