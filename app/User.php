<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        /**
         * With timestaps will create an updated_at and created_at entry.
         * 
         */
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }

    public function voteQuestions()
    {
        /**
         * need to specify a singular table name.
         * Eloquent will recognize that the table is the plural form (votables)
         * with votable_id and votable_type
         */
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers()
    {
        /**
         * need to specify a singular table name.
         * Eloquent will recognize that the table is the plural form (votables)
         * with votable_id and votable_type
         */
        return $this->morphedByMany(Answer::class, 'votable');
    }

    /**
     * Accessors
     */

    public function getUrlAttribute()
    {
        return '#';
    }

    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }

    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();

        if($voteQuestions->where('votable_id', $question->id)->exists() ) {
            $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
        }else {
            $voteQuestions->attach($question,['vote'=>$vote]);
        }

        $question->load('votes');
        $upvotes = (int)$question->upVotes()->sum('vote');
        $downvotes = (int)$question->downVotes()->sum('vote');

        $question->votes_count = $upvotes + $downvotes;
        $question->save();
    }


    public function voteAnswer(Answer $answer, $vote)
    {
         $voteAnswers = $this->voteAnswers();

        if($voteAnswers->where('votable_id', $answer->id)->exists() ) {
            $voteAnswers->updateExistingPivot($answer, ['vote' => $vote]);
        }else {
            $voteAnswers->attach($answer,['vote'=>$vote]);
        }

        $answer->load('votes');
        $upvotes = (int)$answer->upVotes()->sum('vote');
        $downvotes = (int)$answer->downVotes()->sum('vote');

        $answer->votes_count = $upvotes + $downvotes;
        $answer->save();
    }
}
