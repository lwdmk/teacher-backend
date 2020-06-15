@extends('layouts.app')

@section('content')
    <p><a href="{{ route('admin.test.attempts', $test) }}" class="btn btn-primary">К списку</a></p>
    <div class="card">
        <div class="card-header">
            Решение теста: <b>{{ $test->title }}</b> от пользователя: <b>{{ $attempt->name }}</b>
            <div class="small">Проверено: {{ $resultData['checkDate'] ?? '-' }}</div>
        </div>
        <div class="card-body">
            <h3><i>Вопросы:</i></h3>
            <div class="d-flex flex-column font">
                @php  $index = 1 @endphp
                @foreach(($resultData['checkedResult'] ?? []) as $questionId => $result)
                    @php $question = $questionsById[$questionId] ?? null @endphp
                    <div class="card col-12 mb-2 {{$result['isCorrect'] ? 'alert alert-success' : ''}}">
                        @if(!is_null($question))
                            <div class="card-body d-flex flex-column">
                                <div class="text-justify pr-3 mb-1">
                                    <div>
                                        <b>{{ \App\Entity\Test\TestQuestion::getTypesList()[$question->type] }}</b>
                                    </div>
                                    <b class="ml-10"># {{($index)}}. ID: {{ $questionId }}.</b>
                                    {{ $question->title }}
                                    @if(is_null($result['userAnswer']))
                                        <p class="mt-2 p-2 alert-danger">На вопрос не был дан ответ</p>
                                    @endif
                                </div>
                                <div class="p-1">
                                    <ul class="list-group">
                                        @foreach($question->answers as $i => $answer)
                                            @if(in_array($question->type, [\App\Entity\Test\TestQuestion::TYPE_ONE_ANSWER_FROM_ROW, \App\Entity\Test\TestQuestion::TYPE_MULTIPLE_ANSWERS_FROM_ROW]))
                                                <li class="list-group-item"
                                                    style="{{ (is_array($result['rightAnswers']) && in_array($answer->id, $result['rightAnswers'])) ? 'background-color: #dbf0db': ''}}">
                                                    @if (is_array($result['userAnswer']) && in_array($answer->id, $result['userAnswer']))
                                                        <span
                                                            style="font-size: 24px; {{(is_array($result['rightAnswers']) && in_array($answer->id, $result['rightAnswers'])) ? 'color:green': 'color:red'}}"
                                                            class="high">✔</span>
                                                    @endif
                                                    <b>{{$i + 1 }}</b> {{$answer->text}}
                                                    <div class="small">ID: {{$answer->id}}</div>
                                                </li>
                                            @endif
                                            @if(in_array($question->type, [\App\Entity\Test\TestQuestion::TYPE_WRITE_AN_ANSWER]))
                                                @if(is_string($result['rightAnswers']) && is_string($result['userAnswer']) && $result['rightAnswers'] === $result['userAnswer'])
                                                    <li class="list-group-item">
                                                        <span style="font-size: 24px; color:green">✔</span>
                                                        {{ $result['userAnswer'] }}
                                                    </li>
                                                @else
                                                    <li class="list-group-item" style="background-color: #f7dddc">
                                                        {{ is_string($result['userAnswer']) ? $result['userAnswer'] : 'Неверный формат' }}
                                                    </li>
                                                    <li class="list-group-item" style="background-color: #dbf0db">
                                                        {{ is_string($result['rightAnswers']) ? $result['rightAnswers'] : 'Неверный формат' }}
                                                    </li>
                                                @endif
                                            @endif
                                            @if(in_array($question->type, [\App\Entity\Test\TestQuestion::TYPE_RECOVER_AN_ORDER]))
                                                <li class="list-group-item">
                                                    <b>{{$i + 1 }}</b> {{$answer->text}}
                                                    <div class="small">ID: {{$answer->id}}</div>
                                                    <span
                                                        style="font-size: 24px; {{(($result['rightAnswers'][$answer->id] ?? true) === ($result['userAnswer'][$answer->id] ?? false)) ? 'color:green': 'color:red'}}"
                                                        class="high">✔
                                                    </span>
                                                    <div>Верное место в последовательности <b>{{ $result['rightAnswers'][$answer->id] ?? 'Ошибка формата' }}</b></div>
                                                    <div>Указанное место в последовательности <b>{{ $result['userAnswer'][$answer->id] ?? 'Ошибка формата' }}</b></div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            В текущем представлении теста вопрос не найден
                        @endif
                    </div>
                    @php  $index ++ @endphp
                @endforeach
            </div>
        </div>
    </div>
@endsection
