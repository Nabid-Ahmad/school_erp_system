<?php

use App\Http\Controllers\System\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $galleries = \App\Models\Gallery::latest()->take(6)->get();
    $events = \App\Models\Event::latest()->take(4)->get();
    return view('welcome', compact('galleries', 'events'));
});

Route::get('/dashboard', function () {
    $totalStudents = \App\Models\Student::count();
    $totalTeachers = \App\Models\Teacher::count();
    $todayAttendance = \App\Models\Attendance::whereDate('date', now())->where('status', 'present')->count();
    $monthlyFees = \App\Models\Fee::whereMonth('created_at', now()->month)
                                 ->whereYear('created_at', now()->year)
                                 ->sum('amount');
    $totalExpenses = \App\Models\Expense::sum('amount');

    return view('dashboard', compact('totalStudents', 'totalTeachers', 'todayAttendance', 'monthlyFees', 'totalExpenses'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Public Contact Route (Accessible without login)
Route::post('/contact/send', [\App\Http\Controllers\CMS\ContactController::class, 'send'])->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class)->name('contact.send');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Only (Super Admin)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\System\UserController::class);
        Route::get('/settings', [\App\Http\Controllers\System\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\System\SettingController::class, 'update'])->name('settings.update');
    });

    // Permission Based Routes
    Route::middleware('can:manage classes')->group(function () {
        Route::resource('classes', \App\Http\Controllers\Academic\SchoolClassController::class);
    });
    
    Route::middleware('can:manage subjects')->group(function () {
        Route::resource('subjects', \App\Http\Controllers\Academic\SubjectController::class);
    });
    
    Route::middleware('can:manage teachers')->group(function () {
        Route::resource('teachers', \App\Http\Controllers\HR\TeacherController::class);
        Route::get('/teachers/{teacher}', [\App\Http\Controllers\HR\TeacherProfileController::class, 'show'])->name('teachers.show');
        Route::get('/teachers/{teacher}/id-card', [\App\Http\Controllers\HR\TeacherProfileController::class, 'idCard'])->name('teachers.id-card');
    });
    
    Route::middleware('can:manage students')->group(function () {
        Route::resource('students', \App\Http\Controllers\Student\StudentController::class);
        Route::get('/students/{student}/id-card', [\App\Http\Controllers\Student\StudentController::class, 'generateIDCard'])->name('students.id-card');
        Route::get('/students/{student}/dues', [\App\Http\Controllers\Student\StudentController::class, 'dues'])->name('students.dues');
        Route::get('/api/students/find/{roll}', [\App\Http\Controllers\Student\StudentController::class, 'apiFind'])->name('api.students.find');
    });
    
    Route::middleware('can:manage fees')->group(function () {
        Route::resource('fees', \App\Http\Controllers\Finance\FeeController::class);
        Route::get('/fees/{fee}/receipt', [\App\Http\Controllers\Finance\FeeController::class, 'downloadReceipt'])->name('fees.receipt');
        Route::get('/fee-structures', [\App\Http\Controllers\Finance\FeeStructureController::class, 'index'])->name('fee-structures.index');
        Route::post('/fee-structures', [\App\Http\Controllers\Finance\FeeStructureController::class, 'store'])->name('fee-structures.store');
    });
    
    Route::middleware('can:manage galleries')->group(function () {
        Route::resource('galleries', \App\Http\Controllers\CMS\GalleryController::class);
    });
    
    Route::middleware('can:manage events')->group(function () {
        Route::resource('events', \App\Http\Controllers\CMS\EventController::class);
    });
    
    Route::middleware('can:manage expenses')->group(function () {
        Route::resource('expenses', \App\Http\Controllers\Finance\ExpenseController::class);
    });
    
    Route::middleware('can:manage promotions')->group(function () {
        Route::get('/promotions', [\App\Http\Controllers\Academic\PromotionController::class, 'index'])->name('promotions.index');
        Route::post('/promotions', [\App\Http\Controllers\Academic\PromotionController::class, 'promote'])->name('promotions.promote');
    });
    
    Route::middleware('can:manage salaries')->group(function () {
        Route::get('/salaries', [\App\Http\Controllers\HR\SalaryController::class, 'index'])->name('salaries.index');
        Route::post('/salaries', [\App\Http\Controllers\HR\SalaryController::class, 'store'])->name('salaries.store');
    });

    // Admin, Staff (with permission) & Teacher Routes
    Route::middleware('role:admin,teacher,manage attendances')->group(function () {
        Route::resource('attendances', \App\Http\Controllers\Student\AttendanceController::class);
    });

    Route::middleware('role:admin,teacher,manage results')->group(function () {
        Route::resource('results', \App\Http\Controllers\Academic\ResultController::class);
    });
});

require __DIR__.'/auth.php';
