<?php

use App\Http\Controllers\Admin\PreviousQuestionController;
use App\Http\Controllers\Admin\QuestionTypeController;
use App\Http\Controllers\Admin\QuestionYearController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuizManageController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', function () {
    return view('layouts.frontEnd.index');
});

Route::get('/users/list/view', function () {
    return view('layouts.admin.users.user');
});
Route::get('/users/contact-info', function () {
    return view('layouts.admin.contactInfo.contact-info');
});
Route::get('/users/blog-post', function () {
    return view('layouts.admin.blog.blog-post');
});
Route::get('/users/profile', function () {
    return view('layouts.admin.profile.profile');
});
Route::get('/quiz/list/view', function () {
    return view('layouts.admin.quiz.quiz');
});
Route::get('/add-quiz', function () {
    return view('layouts.admin.quiz.add-quiz');
});
Route::get('/add-quiz-question', function () {
    return view('layouts.admin.quiz.add-quiz-question');
});
Route::get('/add-previous-question', function () {
    return view('layouts.admin.previousQuestion.previous-question');
});
Route::get('/show-question', function () {
    return view('layouts.admin.previousQuestion.show-question');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('layouts.admin.exam');
})->name('dashboard');

//User
Route::resource('users', UserController::class);
Route::get('/find-user', [UserController::class, 'search']);

//Profile
Route::get('/profile', [UserController::class, 'profile']);
Route::patch('/profile/{id}', [UserController::class, 'updateProfile']);

//Quiz
Route::resource('quiz', QuizController::class);
Route::post('/quiz/question', [QuizController::class, 'addQuizQuestion'])
    ->name('question');
Route::get('/get-question', [QuizController::class, 'getQuizQuestion'])
    ->name('get_question');

//Previous question
Route::resource('get-years', QuestionYearController::class);
Route::resource('get-types', QuestionTypeController::class);

Route::resource('previous-question', PreviousQuestionController::class);