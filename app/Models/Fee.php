<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = ['student_id', 'amount', 'fee_type', 'month', 'year', 'status'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
