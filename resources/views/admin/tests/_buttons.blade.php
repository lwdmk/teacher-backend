<div class="d-lg-flex flex-lg-row justify-content-lg-between">
    <h2><b class="mr-1">Тест ID: {{$test->id}}.</b>{{ $test->title }}</h2>

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.test.question.create', $test) }}" class="btn btn-secondary mr-1">Добавить
            вопрос</a>
        <a href="{{ route('admin.test.show', $test) }}" class="btn btn-info mr-1">Просмотр вопросов</a>
        <a href="{{ route('admin.test.edit', $test) }}" class="btn btn-primary mr-1">Редактировать</a>
        <a href="{{ route('admin.test.attempts', $test) }}" class="btn btn-dark mr-1">Прохождения</a>
        <form method="POST" action="{{ route('admin.test.destroy', $test) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Удалить</button>
        </form>
    </div>
</div>
