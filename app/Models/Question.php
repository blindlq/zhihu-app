<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
    //
    protected  $fillable = ['title','body','user_id'];


    /**
     * 话题和问题多对多
     */
    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //问题与回答一对多
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function scopePublished($query)
    {
        return $query->where('is_hidden','F');
    }
}
