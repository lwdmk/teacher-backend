@extends('layouts.app')

@section('content')
    @include('admin.tests._nav')

    <form method="POST" action="{{ route('admin.test.question.update', [$test, $question]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="test_id" value="{{$test->id}}">
        <div class="form-group">
            <label for="title" class="col-form-label">Введите вопрос</label>
            <textarea id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" rows="5" name="title" required>{{ old('title', $question->title) }}</textarea>
            @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="type" class="col-form-label">Тип</label>
            <select id="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type">
                <option value=""></option>
                @foreach (\App\Entity\Test\TestQuestion::getTypesList() as $typeId => $type)
                    <option value="{{ $typeId }}" {{ $typeId == old('type', $question->type) ? ' selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach;
            </select>
            @if ($errors->has('type'))
                <span class="invalid-feedback"><strong>{{ $errors->first('type') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection
