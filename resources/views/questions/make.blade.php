
@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">发布问题</div>
                    <div class="card-body">
                        <form action="{{ route('question.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="title" class="form-control" placeholder="标题" id="title">
                            </div>

                            <script id="container" name="body" type="text/plain"></script>

                            <button class="btn btn-success pull-right" type="submit">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
    @endsection