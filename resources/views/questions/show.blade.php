@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $question->title }}
                        @foreach($question->topics as $topic)
                            <a class="topic pull-right" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                            @endforeach
                    </div>

                    <div class="card-body">
                        {!! $question->body !!}
                    </div>
                    <div class="action" style=" display: flex;padding: 10px 20px;">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="{{ route('question.edit',$question->id)}}">编辑</a></span>
                            <form action="{{ route('question.destroy',$question->id) }}" method="POST" class="delete-form">
                                {{ method_field('DELETE') }}
                                @csrf
                                <button class="button is_naked delete" style="color: #007bff;background: 0 0;border: none;border-radius: 0;padding: 0;height: auto;">删除</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
