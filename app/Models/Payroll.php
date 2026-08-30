<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['month', 'year', 'total_amount', 'status', 'created_by'];

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
