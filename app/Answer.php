<?php

namespace App;

use Parsedown;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
     /**
     * All methods available in the trait will be included here
     */
    use VotableTrait;

    protected $fillable = ['body', 'user_id'];

     /**
     * need to add the accessor in append to make it visible in model representation 
     * outside of Laravel
     */
    protected $appends = ['created_date', 'body_html'];

    
    /**
     * Relationships
     */

    public function question()
    {
        return $this->belongsTo(Question::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
      * Accessor
      */

    public function getBodyHtmlAttribute()
    {
        return Parsedown::instance()->text($this->body);
        
    }

    public function getCreatedDateAttribute()
    {
        /**
         * Date can be also presented in other format
         * example: created_at->format("d/m/Y")
         */
        return $this->created_at->diffForHumans();
    }


    public function getStatusAttribute()
    {
        return $this->id === $this->question->best_answer_id ? 'vote-accepted' : '';
    }


    public function getIsBestAttribute()
    {
        return $this->isBest();
    }


    /**
     * Events
     */

    public static function boot()
    {
        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answers_count');
        });

        static::deleted(function($answer){

            $question = $answer->question;

            $question->decrement('answers_count');

            if($question->best_answer_id == $answer->id){
                $question->best_answer_id = NULL;
                $question->save();
            }


        });
    }

    /**
     * Other Methods
     */

     public function isBest()
     {
         return $this->id === $this->question->best_answer_id;
     }

    
}
