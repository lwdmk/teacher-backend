@extends('layouts.app')

@section('content')
    @include ('admin._nav', ['page' => ''])

    <h3>Последние пройденные тесты</h3>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Тест</th>
            <th>Имя пользователя</th>
            <th>Результат</th>
            <th>Начато</th>
            <th>Выполнить до</th>
            <th>Завершено</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($attempts as $attempt)
            <tr>
                <td>{{ $attempt->id }}</td>
                <td>
                    <a href="{{ route('admin.test.show', [$attempt->test]) }}">
                        {{ $attempt->test->title  }}
                    </a>
                </td>
                <td>{{ $attempt->name }}</td>
                <td>{{ $attempt->score }} %</td>
                <td>{{ $attempt->created_at }}</td>
                <td>{{ $attempt->ended_at }}</td>
                <td>{{ $attempt->completed_at ?? 'не завершено' }}</td>
                <td>
                    @if ($attempt->isNotCompleted())
                        Не завершен
                    @else
                        <a href="{{ route('admin.test.attempt', [$attempt->test, $attempt]) }}">
                            @if ($attempt->isExpired())
                                Проверить и посмотреть
                            @else
                                Посмотреть
                            @endif
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $attempts->links() }}


@endsection
