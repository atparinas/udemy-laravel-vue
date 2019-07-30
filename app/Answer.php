<?php

namespace App;

use Parsedown;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $fillable = ['body', 'user_id'];
    
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
                $answer->question->decrement('answers_count');
            });
       }
}
