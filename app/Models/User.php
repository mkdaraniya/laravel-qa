<?php

namespace App\Models;

use App\Models\Question;
use Doctrine\DBAL\Query;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
//        return route("user.show", $this->id);
return '#';
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); //, 'author_id', 'question_id');
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable');
    }

    
    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }


    public function voteQuestion(Question $question,$vote)
    {
        $voteQuestions = $this->voteQuestions();

        if($voteQuestions->where('votable_id', $question->id)->exists()){
            $voteQuestions->updateExistingPivot($question,['vote' => $vote]);
        }else{
            $voteQuestions->attach($question, ['vote' => $vote]);
        }

        $question->load('votes');
        $downVotes = (int)$question->downVotes()->sum('vote');
        $upVotes = (int)$question->upVotes()->sum('vote');

        $question->votes_count = $upVotes + $downVotes;
        // $question->votable_id = auth()->id();
        $question->save();
    }

    public function voteAnswer(Answer $answer,$vote)
    {
        $voteAnswers = $this->voteAnswers();

        if($voteAnswers->where('votable_id', $answer->id)->exists()){
            $voteAnswers->updateExistingPivot($answer,['vote' => $vote]);
        }else{
            $voteAnswers->attach($answer, ['vote' => $vote]);
        }

        $answer->load('votes');
        $downVotes = (int)$answer->downVotes()->sum('vote');
        $upVotes = (int)$answer->upVotes()->sum('vote');

        $answer->votes_count = $upVotes + $downVotes;
        // $answer->votable_id = auth()->id();
        $answer->save();
    }
}