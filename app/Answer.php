<?php

namespace App;

use Parsedown;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    
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
}
