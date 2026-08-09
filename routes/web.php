<?php

use App\Http\Controllers\Academic\PromotionController;
use App\Http\Controllers\Academic\ResultController;
use App\Http\Controllers\Academic\SchoolClassController;
use App\Http\Controllers\Academic\SubjectController;
use App\Http\Controllers\CMS\ContactController;
use App\Http\Controllers\CMS\EventController;
use App\Http\Controllers\CMS\GalleryController;
use App\Http\Controllers\Finance\ExpenseController;
use App\Http\Controllers\Finance\FeeController;
use App\Http\Controllers\Finance\FeeStructureController;
use App\Http\Controllers\HR\SalaryController;
use App\Http\Controllers\HR\TeacherController;
use App\Http\Controllers\HR\TeacherProfileController;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\System\ProfileController;
use App\Http\Controllers\System\SettingController;
use App\Http\Controllers\System\UserController;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Expense;
use App\Models\Fee;
use App\Models\Gallery;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('/', function () {
    $galleries = Gallery::latest()->take(6)->get();
    $events = Event::latest()->take(4)->get();

    return view('welcome', compact('galleries', 'events'));
});

Route::get('/dashboard', function () {
    $totalStudents = Student::count();
    $totalTeachers = Teacher::count();
    $todayAttendance = Attendance::whereDate('date', now())->where('status', 'present')->count();
    $monthlyFees = Fee::where('status', 'paid')
        ->where('month', now()->format('F'))
        ->where('year', (string) now()->year)
        ->sum('amount');
    $monthlyExpenses = Expense::whereYear('date', now()->year)
        ->whereMonth('date', now()->month)
        ->sum('amount');

    return view('dashboard', compact('totalStudents', 'totalTeachers', 'todayAttendance', 'monthlyFees', 'monthlyExpenses'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Public Contact Route (Accessible without login)
Route::post('/contact/send', [ContactController::class, 'send'])->middleware(ProtectAgainstSpam::class)->name('contact.send');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Only (Super Admin)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // Permission Based Routes
    Route::middleware('can:manage classes')->group(function () {
        Route::resource('classes', SchoolClassController::class);
    });

    Route::middleware('can:manage subjects')->group(function () {
        Route::resource('subjects', SubjectController::class);
    });

    Route::middleware('can:manage teachers')->group(function () {
        Route::resource('teachers', TeacherController::class);
        Route::get('/teachers/{teacher}', [TeacherProfileController::class, 'show'])->name('teachers.show');
        Route::get('/teachers/{teacher}/id-card', [TeacherProfileController::class, 'idCard'])->name('teachers.id-card');
    });

    Route::middleware('can:manage students')->group(function () {
        Route::resource('students', StudentController::class);
        Route::get('/students/{student}/id-card', [StudentController::class, 'generateIDCard'])->name('students.id-card');
        Route::get('/students/{student}/dues', [StudentController::class, 'dues'])->name('students.dues');
        Route::get('/api/students/find/{roll}', [StudentController::class, 'apiFind'])->name('api.students.find');
    });

    Route::middleware('can:manage fees')->group(function () {
        Route::resource('fees', FeeController::class);
        Route::get('/fees/{fee}/receipt', [FeeController::class, 'downloadReceipt'])->name('fees.receipt');
        Route::get('/fee-structures', [FeeStructureController::class, 'index'])->name('fee-structures.index');
        Route::post('/fee-structures', [FeeStructureController::class, 'store'])->name('fee-structures.store');
    });

    Route::middleware('can:manage galleries')->group(function () {
        Route::resource('galleries', GalleryController::class);
    });

    Route::middleware('can:manage events')->group(function () {
        Route::resource('events', EventController::class);
    });

    Route::middleware('can:manage expenses')->group(function () {
        Route::resource('expenses', ExpenseController::class);
    });

    Route::middleware('can:manage promotions')->group(function () {
        Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
        Route::post('/promotions', [PromotionController::class, 'promote'])->name('promotions.promote');
    });

    Route::middleware('can:manage salaries')->group(function () {
        Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
        Route::post('/salaries', [SalaryController::class, 'store'])->name('salaries.store');
        Route::delete('/salaries/{salary}', [SalaryController::class, 'destroy'])->name('salaries.destroy');
    });

    // Admin, Staff (with permission) & Teacher Routes
    Route::middleware('role:admin,teacher,manage attendances')->group(function () {
        Route::resource('attendances', AttendanceController::class);
    });

    Route::middleware('role:admin,teacher,manage results')->group(function () {
        Route::resource('results', ResultController::class);
    });
});

require __DIR__.'/auth.php';
