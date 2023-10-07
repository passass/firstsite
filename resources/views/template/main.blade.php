<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
            Главная Страница
    </title>
    <link href="{{ asset('css/template/main.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.js') }}"></script> 
    @yield('styles')
</head>
<body>
    @yield('tabs')
    <div class="tabs__">
        <div class="tabs__uptab">
            <div class="tabs__uptab__content">
                <div class="tabs__uptab__content__logo">
                    <a href="{{ url('index') }}">
                        Todo
                    </a>
                </div>
                <div class="line_grid_layout">
                    <div>
                        <a href="{{ url('about') }}">
                            <h2>О нас</h2>
                        </a>
                    </div>
                    @if (auth()->check())
                        <div>
                            <a href="{{ url('todos') }}">
                                <h2>Список дел</h2>
                            </a>
                        </div>
                        <div>
                            <a>
                                <h2>{{auth()->user()->name}}</h2>
                            </a>
                        </div>
                        <div last>
                            <a href="{{ url('logout') }}">
                                <h2>Выйти</h2>
                            </a>
                        </div>
                    @else
                        <div>
                            <a href="{{ url('login') }}">
                                <h2>Авторизироваться</h2>
                            </a>
                        </div>
                        <div last>
                            <a href="{{ url('register') }}">
                                <h2>Зарегистрироваться</h2>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if (empty($hidecentertab))
        <div class="tabs__centertab">
            @yield('inblock')
        </div>
        @endif
    </div>
    @yield('content')
</body>
</html>