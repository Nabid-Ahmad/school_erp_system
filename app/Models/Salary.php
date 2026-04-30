<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = ['teacher_id', 'amount', 'month', 'year', 'payment_date', 'status', 'note'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
