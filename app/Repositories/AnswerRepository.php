<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2018/6/3
 * Time: 下午9:57
 */

namespace App\Repositories;


use App\Models\Answer;


class AnswerRepository
{
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }
}