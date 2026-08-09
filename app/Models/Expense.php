<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['salary_id', 'title', 'amount', 'category', 'date', 'month', 'year', 'description'];
}
