@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <p><a href="{{ route('admin.users.index') }}" class="btn btn-success">К списку</a></p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Тест</th>
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
                <td><a href="{{ route('admin.test.show', $attempt->test) }}">{{ $attempt->test->title }}</a></td>
                <td>{{ $attempt->score }} %</td>
                <td>{{ $attempt->created_at }}</td>
                <td>{{ $attempt->ended_at }}</td>
                <td>{{ $attempt->completed_at ?? 'не завершено' }}</td>
                <td><a href="{{ route('admin.tests.attempt', $attempt) }}">Посмотреть</a></td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $attempts->links() }}
@endsection
