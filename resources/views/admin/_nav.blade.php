<ul class="nav nav-tabs mb-3">
    @can ('admin-panel')
        <li class="nav-item"><a class="nav-link{{ $page === '' ? ' active' : '' }}" href="{{ route('admin.home') }}">Главная</a></li>
        <li class="nav-item"><a class="nav-link{{ $page === 'pages' ? ' active' : '' }}" href="{{ route('admin.pages.index') }}">Статьи</a></li>
        <li class="nav-item"><a class="nav-link{{ $page === 'users' ? ' active' : '' }}" href="{{ route('admin.users.index') }}">Пользователи</a></li>
        <li class="nav-item"><a class="nav-link{{ $page === 'tests' ? ' active' : '' }}" href="{{ route('admin.test.index') }}">Тесты</a></li>
    @endcan
</ul>
