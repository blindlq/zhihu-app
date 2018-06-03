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
 * 只与model和数据库打交道，不设计service和controller
 * Class QuestionRepository
 * @package App\Repositories
 *
 */
class QuestionRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        //这个with不是数据表topic而是Models/Question下的topics方法
        return Question::where('id',$id)->with(['topics','answers'])->first();
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Question::find($id);
    }

    public function getQuestionFeed()
    {
        //scope函数的使用
        return Question::published()->latest('updated_at')->with('user')->get();
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