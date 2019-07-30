<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Parsedown;

class Question extends Model
{
    
    protected $fillable = ['title', 'body'];

    /**
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    /**
     * Mutatators
     */

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * Accessors
     * Function Accessor in CamelCase but should be snake case when called in the views
     */

    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
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
        if($this->answers_count > 0){
            if($this->best_answer_id){
                return "answered_accepted";
            }

            return "answered";
        }

        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return Parsedown::instance()->text($this->body);
    }

    /**
     * Other Methods
     */

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

}
