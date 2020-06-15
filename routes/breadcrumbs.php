<?php

use App\Entity\Page;
use App\Entity\User\User;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Crumbs;

Breadcrumbs::register(
    'login',
    function (Crumbs $crumbs) {
        $crumbs->push('Войти', route('login'));
    }
);

// Admin
Breadcrumbs::register(
    'admin.home',
    function (Crumbs $crumbs) {
        $crumbs->push('Главная', route('admin.home'));
    }
);

// Users

Breadcrumbs::register(
    'admin.users.index',
    function (Crumbs $crumbs) {
        $crumbs->parent('admin.home');
        $crumbs->push('Пользователи', route('admin.users.index'));
    }
);

Breadcrumbs::register(
    'admin.users.create',
    function (Crumbs $crumbs) {
        $crumbs->parent('admin.users.index');
        $crumbs->push('Создать', route('admin.users.create'));
    }
);

Breadcrumbs::register(
    'admin.users.show',
    function (Crumbs $crumbs, User $user) {
        $crumbs->parent('admin.users.index');
        $crumbs->push($user->name, route('admin.users.show', $user));
    }
);

Breadcrumbs::register(
    'admin.users.tests',
    function (Crumbs $crumbs, User $user) {
        $crumbs->parent('admin.users.index');
        $crumbs->push($user->name, route('admin.users.show', $user));
        $crumbs->push('Тесты', route('admin.users.tests', $user));
    }
);

Breadcrumbs::register(
    'admin.users.edit',
    function (Crumbs $crumbs, User $user) {
        $crumbs->parent('admin.users.show', $user);
        $crumbs->push('Редактировать', route('admin.users.edit', $user));
    }
);

// Tests

Breadcrumbs::register(
    'admin.test.index',
    function (Crumbs $crumbs) {
        $crumbs->parent('admin.home');
        $crumbs->push('Тесты', route('admin.test.index'));
    }
);

Breadcrumbs::register(
    'admin.test.create',
    function (Crumbs $crumbs) {
        $crumbs->parent('admin.test.index');
        $crumbs->push('Создать', route('admin.test.create'));
    }
);

Breadcrumbs::register(
    'admin.test.show',
    function (Crumbs $crumbs, \App\Entity\Test\Test $test) {
        $crumbs->parent('admin.test.index');
        $crumbs->push($test->title, route('admin.test.show', $test));
    }
);

Breadcrumbs::register(
    'admin.test.question.create',
    function (Crumbs $crumbs, \App\Entity\Test\Test $test) {
        $crumbs->parent('admin.test.index');
        $crumbs->push($test->title, route('admin.test.show', $test));
    }
);

Breadcrumbs::register(
    'admin.test.question.show',
    function (Crumbs $crumbs, \App\Entity\Test\Test $test) {
        $crumbs->parent('admin.test.index');
        $crumbs->push($test->title, route('admin.test.show', $test));
    }
);
Breadcrumbs::register(
    'admin.test.question.edit',
    function (Crumbs $crumbs, \App\Entity\Test\Test $test, \App\Entity\Test\TestQuestion $question) {
        $crumbs->parent('admin.test.index');
        $crumbs->push($test->title, route('admin.test.show', $test));
        $crumbs->push($test->title, route('admin.test.question.show', [$test, $question]));
    }
);

Breadcrumbs::register(
    'admin.test.edit',
    function (Crumbs $crumbs, \App\Entity\Test\Test $test) {
        $crumbs->parent('admin.test.show', $test);
        $crumbs->push('Редактировать', route('admin.test.edit', $test));
    }
);

Breadcrumbs::register(
    'admin.test.attempt',
    function (Crumbs $crumbs, \App\Entity\Test\Test $test, \App\Entity\Test\TestAttempt $attempt) {
        $crumbs->parent('admin.test.index');
        $crumbs->push($test->title, route('admin.test.show', $test));
        $crumbs->push('Прохождения', route('admin.test.attempts', $test));
        $crumbs->push('Прохождение от пользователя: ' . $attempt->name, route('admin.test.attempt', [$test, $attempt]));
    }
);

Breadcrumbs::register(
    'admin.test.attempts',
    function (Crumbs $crumbs, \App\Entity\Test\Test $test) {
        $crumbs->parent('admin.test.index');
        $crumbs->push($test->title, route('admin.test.show', $test));
        $crumbs->push('Прохождения', route('admin.test.attempts', $test));
    }
);

// Pages

Breadcrumbs::register(
    'admin.pages.index',
    function (Crumbs $crumbs) {
        $crumbs->parent('admin.home');
        $crumbs->push('Статьи', route('admin.pages.index'));
    }
);

Breadcrumbs::register(
    'admin.pages.create',
    function (Crumbs $crumbs) {
        $crumbs->parent('admin.pages.index');
        $crumbs->push('Создать', route('admin.pages.create'));
    }
);

Breadcrumbs::register(
    'admin.pages.show',
    function (Crumbs $crumbs, Page $page) {
        $crumbs->parent('admin.pages.index');
        $crumbs->push($page->title, route('admin.pages.show', $page));
    }
);

Breadcrumbs::register(
    'admin.pages.attachments',
    function (Crumbs $crumbs, Page $page) {
        $crumbs->parent('admin.pages.show', $page);
        $crumbs->push('Приложения', route('admin.pages.attachments', $page));
    }
);

Breadcrumbs::register(
    'admin.pages.edit',
    function (Crumbs $crumbs, Page $page) {
        $crumbs->parent('admin.pages.show', $page);
        $crumbs->push('Edit', route('admin.pages.edit', $page));
    }
);
