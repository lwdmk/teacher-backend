@extends('layouts.app')

@section('content')
    @include('admin.tests._nav')

    <p><a href="{{ route('admin.test.create') }}" class="btn btn-success">Добавить тест</a></p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Тип</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($tests as $test)
            <tr>
                <td>{{ $test->id }}</td>
                <td>
                    <a href="{{ route('admin.test.show', $test) }}">{{ $test->title }}</a>
                </td>
                <td>{{ $test->getTypeDescription() }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $tests->links() }}
@endsection
