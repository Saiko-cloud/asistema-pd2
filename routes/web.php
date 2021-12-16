<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MainController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function () {
    return Inertia::render('main/admin');
})->name('admin');

Route::middleware(['auth:sanctum', 'verified'])->get('/teacher', function () {
    return Inertia::render('main/teacher');
})->name('teacher');

Route::middleware(['auth:sanctum', 'verified'])->get('/student', function () {
    return Inertia::render('main/student');
})->name('student');

Route::middleware('auth:sanctum')->post('/newLesson', [MainController::class, 'newLesson'] );
Route::middleware('auth:sanctum')->post('/newUser', [MainController::class, 'newUser'] );
Route::middleware('auth:sanctum')->post('/getAdminData', [MainController::class, 'getAdminData'] );
Route::middleware('auth:sanctum')->post('/changeData', [MainController::class, 'changeData'] );
Route::middleware('auth:sanctum')->post('/deleteData', [MainController::class, 'deleteData'] );
Route::middleware('auth:sanctum')->post('/changeNote', [MainController::class, 'changeNote'] );
Route::middleware('auth:sanctum')->get('/getStudents', [MainController::class, 'getStudents'] );
Route::middleware('auth:sanctum')->get('/getNotes', [MainController::class, 'getNotes'] );
