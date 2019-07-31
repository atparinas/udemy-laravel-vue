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

    public function favorites()
    {
        /**
         * With timestaps will create an updated_at and created_at entry.
         * 
         */
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
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

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }


    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
    /**
     * Other Methods
     */

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

}
