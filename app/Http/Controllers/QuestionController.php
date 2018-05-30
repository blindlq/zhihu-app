<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\StoreQuestionRequest;

/**
 * Class QuestionController
 * @package App\Http\Controllers
 */
class QuestionController extends Controller
{
    protected $questionRepository;
    /**
     * QuestionController constructor.
     */

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth', ['except' => ['index','show']]);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $question = $this->questionRepository->getQuestionFeed();

        return view('questions.index',compact('question'));
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

        $topics = $this->questionRepository->nomalizeTopic($request->get('topics'));

        //
        $data = [
            'title' => $request->title,
            'body'  => $request->body,
            'user_id' => Auth::id(),
        ];

        $question =$this->questionRepository->create($data);

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
       $question =  $this->questionRepository->byIdWithTopics($id);

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
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question)){
        return view('questions.edit',compact('question'));
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request,$id)
    {

        $topics = $this->questionRepository->nomalizeTopic($request->get('topics'));

        $question = $this->questionRepository->byId($id);

        $question->update([
            'title' => $request->title,
            'body'  => $request->body,
        ]);


        //同步
        $question->topics()->sync($topics);

        return redirect()->route('question.show',$question->id);



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
        $question = $this->questionRepository->byId($id);

        if(Auth::user()->owns($question))
        {
            $question->delete();


            return redirect('/');
        }

        abort(403,'Forbidden');
    }


}
