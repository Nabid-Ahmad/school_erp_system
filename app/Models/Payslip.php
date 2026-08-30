<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $fillable = [
        'payroll_id', 'teacher_id', 'basic_salary', 
        'allowance', 'deduction', 'net_salary', 
        'status', 'payment_date'
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
