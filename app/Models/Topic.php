<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Topic extends Model
{
    //
    protected $fillable = [
        'name','questions_count','bio'
    ];

    /**
     * 话题和问题多对多
     */
    public function questions()
    {
       return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
