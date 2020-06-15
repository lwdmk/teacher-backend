@extends('layouts.app')

@section('content')
    @include('admin.tests._nav')
    @include('admin.tests._buttons')
    <h3><i>Вопросы:</i></h3>
    <div class="d-flex flex-column font">
        @foreach($questions as $index => $question)
            <div class="card col-12 mb-2 {{ $question->answers->isEmpty() ? 'alert-danger' : '' }}" >
                <div class="card-body d-flex flex-lg-row justify-content-between">
                    <div class="text-justify pr-3"><b class="ml-10"># {{($index + 1)}}. ID: {{ $question->id }}
                            .</b> {{ $question->title }}</div>
                    <div class="d-flex flex-column">
                        <a class='btn mr-1 mb-2 btn-info'
                           href="{{ route('admin.test.question.show', [$test, $question]) }}">
                            {{ $question->answers->isEmpty() ? 'Задать ответы' : 'Ответы' }}
                        </a>
                        <a class='btn btn-primary mr-1 mb-2'
                           href="{{ route('admin.test.question.edit', [$test, $question]) }}">Редактировать</a>
                        <a class='btn btn-danger mr-1'
                           href="{{ route('admin.test.question.destroy', [$test, $question]) }}">Удалить</a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection
