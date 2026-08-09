<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Services\SalaryDuesService;
use Barryvdh\DomPDF\Facade\Pdf;

class TeacherProfileController extends Controller
{
    public function show(Teacher $teacher)
    {
        $teacher->load('salaries');
        $salaries = $teacher->salaries()->latest()->get();

        $pendingSalaries = app(SalaryDuesService::class)->calculate($teacher)['months'];

        return view('teachers.profile', compact('teacher', 'salaries', 'pendingSalaries'));
    }

    public function idCard(Teacher $teacher)
    {
        $pdf = Pdf::loadView('teachers.id_card_pdf', compact('teacher'));

        return $pdf->stream($teacher->name.'_ID_Card.pdf');
    }
}
