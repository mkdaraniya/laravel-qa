<?php

namespace App\Models;

use Parsedown;
use App\Models\User;
use App\VotableTrait;
use App\Models\Answer;
use PhpParser\Builder\Function_;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stevebauman\Purify\Purify as PurifyPurify;

class Question extends Model
{
    use HasFactory, VotableTrait;

    protected $fillable = ['title','body'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = Purify::clean($value);
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if($this->answers_count > 0){
            if($this->best_answer_id){
                return "answered-accepted";
            }
            return "answered";
        }

        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return Purify::clean($this->bodyHtml());
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class,'favorites', 'question_id','user_id')->withTimestamps();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id',auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return  $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    public function bodyHtml()
    {
        return Parsedown::instance()->text($this->body);
    }
}
