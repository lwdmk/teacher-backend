@extends('layouts.app')

@section('content')
    @include('admin.pages._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-primary mr-1">Редактировать</a>
        <a href="{{ route('admin.pages.attachments', $page) }}" class="btn btn-dark mr-1">Приложения</a>
        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Удалить</button>
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $page->id }}</td>
                </tr>
                <tr>
                    <th>Заголовок</th>
                    <td>{{ $page->title }}</td>
                </tr>
                <tr>
                    <th>Краткий заголовок</th>
                    <td>{{ $page->menu_title }}</td>
                </tr>
                <tr>
                    <th>Имя в url</th>
                    <td>{{ $page->slug }}</td>
                </tr>
                <tr>
                    <th>Описание</th>
                    <td>{{ $page->description }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Содержимое
                </div>
                <div class="card-body pb-1">
                    {!! clean($page->content) !!}
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Приложения
                </div>
                <div class="card-body pb-1">
                    <ul class="list-group">
                        @foreach($page->attachments as $file)
                            <li class="list-group-item d-flex flex-row justify-content-between">
                                @if($file->is_image)
                                    <img width="100" height="100" src="/storage/{{$file->file}}">
                                @endif
                                    <a target="_blank" href="/storage/{{$file->file}}">{{$file->filename ?? 'Имя не задано'}} &darr; </a>
                                <div class="btn-group">
                                    <form method="POST" action="{{ route('admin.pages.delete.attachment', [$page, $file]) }}"
                                          class="mr-1">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Удалить</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
