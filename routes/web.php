<?php

use App\Models\Question;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\VoteAnswerController;
use App\Http\Controllers\AcceptAnswerController;
use App\Http\Controllers\VoteQuestionController;
use App\Http\Controllers\VoteQuestionCountroller;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('questions', QuestionsController::class)->except('show');


Route::post('/questions/{question}/answers',[App\Http\Controllers\AnswersController::class,'store'])->name('answers.store');
Route::resource('questions.answers',AnswersController::class)->except(['index','create','show']);

Route::get('questions/{slug}',[App\Http\Controllers\HomeController::class,function($slug){
    $question = Question::with('answers.user')->where('slug',$slug)->first() ?? abort(404);
    $question->increment('views');
    $question->save();
    return view('questions.show',compact('question'));
}])->name('questions.show');

Route::post('/answers/{answer}/accept',AcceptAnswerController::class)->name('answers.accept');

Route::post('/questions/{question}/favorites',[FavoritesController::class,'store'])->name('questions.favorite');
Route::delete('/questions/{question}/favorites',[FavoritesController::class,'destroy'])->name('questions.unfavorite');

Route::post('/questions/{question}/vote',VoteQuestionController::class);

Route::post('/answers/{answer}/vote',VoteAnswerController::class);

// Route::get('slug', function($slug){
//     return Question::where('slug',$slug)->first() ?? abort(404);
// });