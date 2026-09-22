<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_point',
        'end_point',
        'fare',
    ];

    public function allocations()
    {
        return $this->hasMany(TransportAllocation::class);
    }
}
