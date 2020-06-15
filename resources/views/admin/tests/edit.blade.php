@extends('layouts.app')

@section('content')
    @include('admin.tests._nav')

    <form method="POST" action="{{ route('admin.test.update', $test) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="col-form-label">Название</label>
            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $test->title) }}" required>
            @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="type" class="col-form-label">Тип</label>
            <select id="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type">
                <option value=""></option>
                @foreach (\App\Entity\Test\Test::getTypesList() as $typeId => $type)
                    <option value="{{ $typeId }}" {{ $typeId == old('type', $test->type) ? ' selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach;
            </select>
            @if ($errors->has('type'))
                <span class="invalid-feedback"><strong>{{ $errors->first('type') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="grade" class="col-form-label">Класс</label>
            <select id="grade" class="form-control{{ $errors->has('grade') ? ' is-invalid' : '' }}" name="grade">
                <option value=""></option>
                @foreach (\App\Entity\User\User::gradeList() as $gradeId => $grade)
                    <option value="{{ $gradeId }}" {{ $gradeId == old('grade', $test->grade) ? ' selected' : '' }}>
                        {{ $grade }}
                    </option>
                @endforeach;
            </select>
            @if ($errors->has('grade'))
                <span class="invalid-feedback"><strong>{{ $errors->first('grade') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="duration" class="col-form-label">Продолжительность (мин)</label>
            <input id="duration" class="form-control{{ $errors->has('duration') ? ' is-invalid' : '' }}" name="duration" value="{{ old('duration', ($test->duration / 60)) }}" type="number" min="10" max="180" required>
            @if ($errors->has('duration'))
                <span class="invalid-feedback"><strong>{{ $errors->first('duration') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="short" class="col-form-label">Анонс</label>
            <textarea id="short" class="form-control {{ $errors->has('short') ? ' is-invalid' : '' }}" rows="5" name="short">{{ old('short', $test->short) }}</textarea>
            @if ($errors->has('short'))
                <span class="invalid-feedback"><strong>{{ $errors->first('short') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="description" class="col-form-label">Описание</label>
            <textarea id="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" rows="5" name="description">{{ old('description', $test->description) }}</textarea>
            @if ($errors->has('description'))
                <span class="invalid-feedback"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection
