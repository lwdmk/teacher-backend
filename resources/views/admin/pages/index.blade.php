@extends('layouts.app')

@section('content')
    @include('admin.pages._nav')

    <p><a href="{{ route('admin.pages.create') }}" class="btn btn-success">Создать статью</a></p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Заголовок</th>
            <th>Имя в url</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($pages as $page)
            <tr>
                <td>
                    <a href="{{ route('admin.pages.show', $page) }}">{{ $page->id }}</a>
                </td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->slug }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
