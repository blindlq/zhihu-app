<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Question;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\StoreQuestionRequest;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return '1';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('questions.make');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {

        $topics = $this->nomalizeTopic($request->get('topics'));

        //
        $data = [
            'title' => $request->title,
            'body'  => $request->body,
            'user_id' => Auth::id(),
        ];

        $question = Question::create($data);

        //实现多对多
        $question->topics()->attach($topics);

        return redirect()->route('question.show',$question->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //这个with不是数据表topic而是Models/Question下的topics方法
       $question =  Question::where('id',$id)->with('topics')->first();

       return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function nomalizeTopic(array $topics)
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
