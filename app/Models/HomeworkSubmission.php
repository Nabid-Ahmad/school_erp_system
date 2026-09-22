<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeworkSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'homework_id',
        'student_id',
        'submission_text',
        'file_path',
        'status',
        'grade',
    ];

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
