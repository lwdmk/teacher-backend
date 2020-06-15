@extends('layouts.app')

@section('content')
    @include('admin.tests._nav')
    @include('admin.tests._buttons')

    <p><b class="mr-1">Вопрос ID: {{$question->id}}.</b>{{ $question->title }}</p>
    <p><b>Тип вопроса:</b> {{ $question->getTypesList()[$question->type] }}</p>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <form method="POST" action="{{route('admin.test.question.answer.store', [$test, $question])}}">
                    @csrf
                    @include('admin.questions.answers.type_'.$question->type, [$answers, $question, $errors])
                    <input type="submit" value='Сохранить' class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection
