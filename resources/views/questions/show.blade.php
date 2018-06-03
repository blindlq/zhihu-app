@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $question->title }}
                        @foreach($question->topics as $topic)
                            <a class="topic pull-right" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                            @endforeach
                    </div>

                    <div class="card-body content">
                        {!! $question->body !!}
                    </div>
                    <div class="actions" >
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="{{ route('question.edit',$question->id)}}">编辑</a></span>
                            <form action="{{ route('question.destroy',$question->id) }}" method="POST" class="delete-form">
                                {{ method_field('DELETE') }}
                                @csrf
                                <button class="button is-naked delete-button" >删除</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ $question->anwers_count }}个答案
                    </div>
                    <div class="card-body">
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <a href="">
                                        <img width="36" src="{{ $question->user->avatar }}" alt="{{  $question->user->name }}"/>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="{{ route('question.show',$question->id)  }}">
                                            {{ $answer->user->name }}
                                        </a>
                                    </h4>
                                    {!! $answer->body !!}
                                </div>
                            </div>
                        @endforeach


                        <form action="{{ route('answer.store',$question->id) }}" method="POST">
                            @csrf
                            <div class="form-group{{ $errors->has('body') ? 'has-error' : '' }}">
                                <script id="container" type="text/plain" name="body" style="height: 120px;">
                                    {!! old('body') !!}
                                </script>

                                @if($errors->has('body'))
                                <span class="invalid-feedback" style="display: block;">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                                @endif
                            </div>

                            <button class="btn btn-success pull-right" type="submit">提交答案</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script type="text/javascript">
            var ue = UE.getEditor('container',{
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
            ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
        </script>
    @endsection
@endsection
