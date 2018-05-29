<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/29
 * Time: 10:42
 */

namespace App\Repositories;

use App\Models\Question;
use App\Models\Topic;


/**
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopics($id)
    {
        return Question::where('id',$id)->with('topics')->first();
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    public function byId($id)
    {
        return Question::find($id);
    }

    /**
     * @param array $topics
     * @return array
     */
    public function nomalizeTopic(array $topics)
    {
        return  collect($topics)->map(function ($topic){
            if(is_numeric($topic)){
                Topic::findOrFail($topic)->increment('questions_count');
                return (int) $topic;
            }

            $newTopic = Topic::create(['name'=>$topic,'questions_count'=>1]);

            return $newTopic->id;
        })->toArray();
    }
}