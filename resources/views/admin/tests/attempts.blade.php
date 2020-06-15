@extends('layouts.app')

@section('content')
    @include('admin.tests._nav')

    <p>
        <a href="{{ route('admin.test.index') }}" class="btn btn-success">К списку тестов</a>
        <a href="{{ route('admin.test.show', $test) }}" class="btn btn-dark">К тесту</a>
    </p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
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
                <td>{{ $attempt->name }}</td>
                <td>{{ $attempt->score }} %</td>
                <td>{{ $attempt->created_at }}</td>
                <td>{{ $attempt->ended_at }}</td>
                <td>{{ $attempt->completed_at ?? 'не завершено' }}</td>
                <td>
                    @if ($attempt->isNotCompleted())
                        Не завершен
                    @else
                        <a href="{{ route('admin.test.attempt', [$test, $attempt]) }}">
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
