@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <p><a href="{{ route('admin.users.index') }}" class="btn btn-success">К списку</a></p>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="col-form-label">Имя</label>
            <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                   value="{{ old('name', $user->name) }}">
            @if ($errors->has('name'))
                <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="role" class="col-form-label">Роль</label>
            <select id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role">
                <option value=""></option>
                @foreach (\App\Entity\User\User::rolesList() as $roleId => $role)
                    <option value="{{ $roleId }}" {{ $roleId == old('role', $user->role) ? ' selected' : '' }}>
                        {{ $role }}
                    </option>
                @endforeach;
            </select>
            @if ($errors->has('role'))
                <span class="invalid-feedback"><strong>{{ $errors->first('role') }}</strong></span>
            @endif
        </div>

        <div class="form-group student-field">
            <label for="grade" class="col-form-label">Класс</label>
            <select id="grade" class="form-control{{ $errors->has('grade') ? ' is-invalid' : '' }}" name="grade">
                <option value=""></option>
                @foreach (\App\Entity\User\User::gradeList() as $gradeId => $grade)
                    <option value="{{ $gradeId }}" {{ $gradeId == old('grade', $user->grade) ? ' selected' : '' }}>
                        {{ $grade }}
                    </option>
                @endforeach;
            </select>
            @if ($errors->has('grade'))
                <span class="invalid-feedback"><strong>{{ $errors->first('grade') }}</strong></span>
            @endif
        </div>

        <div class="form-group student-field">
            <label for="grade_letter" class="col-form-label">Буква класса</label>
            <select id="grade_letter" class="form-control{{ $errors->has('grade_letter') ? ' is-invalid' : '' }}"
                    name="grade_letter">
                <option value=""></option>
                @foreach (\App\Entity\User\User::gradeLetterList() as $gradeLetterId => $gradeLetter)
                    <option
                        value="{{ $gradeLetterId }}" {{ $gradeLetterId == old('grade', $user->grade_letter) ? ' selected' : '' }}>
                        {{ $gradeLetter }}
                    </option>
                @endforeach;
            </select>
            @if ($errors->has('grade_letter'))
                <span class="invalid-feedback"><strong>{{ $errors->first('grade_letter') }}</strong></span>
            @endif
        </div>

        <div class="form-group student-field">
            <label for="access_code" class="col-form-label">Код ученика</label>
            <input id="access_code" type="text"
                   class="form-control{{ $errors->has('access_code') ? ' is-invalid' : '' }}" name="access_code"
                   value="{{ old('access_code', $user->access_code) }}">
            @if ($errors->has('access_code'))
                <span class="invalid-feedback"><strong>{{ $errors->first('access_code') }}</strong></span>
            @endif
        </div>

        <div class="form-group admin-field">
            <label for="email" class="col-form-label">E-Mail</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   name="email" value="{{ old('email', $user->email) }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </div>

        <div class="form-group admin-field">
            <label for="password" class="col-form-label">Пароль</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                   name="password" value="{{ old('password') }}">
            @if ($errors->has('password'))
                <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        function hideFields() {
            let value = $('#role option:selected').val();
            if (value === 'user') {
                $('.student-field').show();
                $('.admin-field').hide();
            }
            if (value === 'admin') {
                $('.student-field').hide();
                $('.admin-field').show();
            }
            if (value === '') {
                $('.student-field, .admin-field').hide();
            }
        }

        hideFields();
        $('#role').on('change', hideFields)
    </script>
@endsection
