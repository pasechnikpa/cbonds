@extends('layouts.base')

@section('title', 'Тестовое задание CBONDS')

@section('content')

    <div class="container mainpage">
        <div class="content">

            <div class="row">
                Существует таблица products полями id, name, priсе. Необходимо реализовать ее отображение со следующим функционалом:
            </div>

            <div class="row">
                <ul>
                    <li>Фильтрация по полю name</li>
                    <li>Пагинация по 25 записей на странице</li>
                    <li>Добавление новой записи</li>
                    <li>Редактирование записи</li>
                    <li>Удаление записи</li>
                </ul>
            </div>

            <div class="row">
                Вывод данных и выполнение операций необходимо осуществлять без перезагрузки страницы с использованием vue.js.
            </div>

            <div class="row">
                Необходимая модель Product и миграция с фабрикой уже созданы. Используемая база данных не имеет значения (можно использовать как mysql так и sqlite).
            </div>

            <div class="row">
                Также уже создан контроллер TestController, где можно размещать необходимый функционал. Необходимо создать сервисный слой и организовать валидацию данных.
            </div>

            <div class="row">
                Полученный результ можно прислать архивом по почте, выложить в облако или в своем репозитории.
            </div>
            <router-view name="companiesIndex"></router-view>
            <router-view></router-view>
        </div>
    </div>
@endsection
