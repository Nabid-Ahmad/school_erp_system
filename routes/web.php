<?php

use App\Http\Controllers\Academic\PromotionController;
use App\Http\Controllers\Academic\ResultController;
use App\Http\Controllers\Academic\SchoolClassController;
use App\Http\Controllers\Academic\SubjectController;
use App\Http\Controllers\CMS\ContactController;
use App\Http\Controllers\CMS\EventController;
use App\Http\Controllers\CMS\GalleryController;
use App\Http\Controllers\Finance\AccountController;
use App\Http\Controllers\Finance\ExpenseController;
use App\Http\Controllers\Finance\FeeController;
use App\Http\Controllers\Finance\FeeStructureController;
use App\Http\Controllers\HR\SalaryController;
use App\Http\Controllers\HR\TeacherController;
use App\Http\Controllers\HR\TeacherProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\System\NotificationController;
use App\Http\Controllers\System\ProfileController;
use App\Http\Controllers\System\ReportController;
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
    $user = auth()->user();

    $totalStudents = $user->can('manage students') ? Student::count() : null;
    $totalTeachers = $user->can('manage teachers') ? Teacher::count() : null;
    $todayAttendance = $user->can('manage attendances') ? Attendance::whereDate('date', now())->where('status', 'present')->count() : null;

    $canViewFinance = $user->can('manage fees') || $user->can('manage expenses') || $user->role === 'admin';
    $monthlyFees = $canViewFinance
        ? Fee::where('status', 'paid')
            ->where('month', now()->format('F'))
            ->where('year', (string) now()->year)
            ->sum('amount')
        : null;
    $monthlyExpenses = $canViewFinance
        ? Expense::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('amount')
        : null;

    return view('dashboard', compact('totalStudents', 'totalTeachers', 'todayAttendance', 'monthlyFees', 'monthlyExpenses'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Public Contact Route (Accessible without login)
Route::post('/contact/send', [ContactController::class, 'send'])->middleware(ProtectAgainstSpam::class)->name('contact.send');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/search', [SearchController::class, 'index'])->name('search');

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Admin Only (Super Admin)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // Permission Based Routes
    Route::middleware('can:manage classes')->group(function () {
        Route::resource('classes', SchoolClassController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    });

    Route::middleware('can:manage subjects')->group(function () {
        Route::resource('subjects', SubjectController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    });

    Route::middleware('can:manage teachers')->group(function () {
        Route::resource('teachers', TeacherController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::get('/teachers/{teacher}', [TeacherProfileController::class, 'show'])->name('teachers.show');
        Route::get('/teachers/{teacher}/id-card', [TeacherProfileController::class, 'idCard'])->name('teachers.id-card');
    });

    Route::middleware('can:manage students')->group(function () {
        Route::resource('students', StudentController::class);
        Route::get('/students/{student}/id-card', [StudentController::class, 'generateIDCard'])->name('students.id-card');
        Route::get('/students/{student}/dues', [StudentController::class, 'dues'])->name('students.dues');
    });

    Route::get('/api/students/find/{roll}', [StudentController::class, 'apiFind'])
        ->middleware('canManageStudentsOrFees')
        ->name('api.students.find');

    Route::middleware('can:manage fees')->group(function () {
        Route::resource('fees', FeeController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::get('/fees/{fee}/receipt', [FeeController::class, 'downloadReceipt'])->name('fees.receipt');
        Route::get('/fee-structures', [FeeStructureController::class, 'index'])->name('fee-structures.index');
        Route::post('/fee-structures', [FeeStructureController::class, 'store'])->name('fee-structures.store');
    });

    Route::middleware('can:manage galleries')->group(function () {
        Route::resource('galleries', GalleryController::class)
            ->only(['index', 'create', 'store', 'destroy']);
    });

    Route::middleware('can:manage events')->group(function () {
        Route::resource('events', EventController::class)
            ->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    // Reports Center Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/financial', [ReportController::class, 'financialSummary'])->name('reports.financial');
    Route::get('/reports/student-dues', [ReportController::class, 'studentDues'])->name('reports.student-dues');
    Route::get('/reports/attendance', [ReportController::class, 'attendanceSummary'])->name('reports.attendance');
    Route::get('/reports/results', [ReportController::class, 'examResults'])->name('reports.results');
    Route::get('/reports/payroll', [ReportController::class, 'payrollSummary'])->name('reports.payroll');

    Route::middleware('can:manage expenses')->group(function () {
        Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
        Route::get('/accounts/report', [AccountController::class, 'report'])->name('accounts.report');
        Route::resource('expenses', ExpenseController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
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
        Route::resource('attendances', AttendanceController::class)
            ->only(['index', 'create', 'store']);
    });

    Route::middleware('role:admin,teacher,manage results')->group(function () {
        Route::resource('results', ResultController::class)
            ->only(['index', 'create', 'store']);
    });
});

require __DIR__.'/auth.php';
