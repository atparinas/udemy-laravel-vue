<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    
    protected $fillable = ['title', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->id);
    }

    //Function Accessor in CamelCase but should be snake case when called in the views
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
        if($this->answers > 0){
            if($this->best_answer_id){
                return "answered_accepted";
            }

            return "answered";
        }

        return "unanswered";
    }
}
