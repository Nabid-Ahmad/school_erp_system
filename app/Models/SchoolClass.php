<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = ['name', 'monthly_fee', 'admission_fee'];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
