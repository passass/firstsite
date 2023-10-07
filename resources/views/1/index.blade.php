<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">

        <title>Index</title>
    </head>
    <body>
        @if (auth()->check())
            <div>
                {{auth()->user()->name}}
            </div>

            <input placeholder="название">
            <input placeholder="текст">
            
            @foreach ($todos as $todo)
                <div>
                    НАЗВАНИЕ:
                    {{$todo->title}}
                    ТЕКСТ:
                    {{$todo->text}}
                </div>
            @endforeach
            <br>
        @endif
        <a href="{{url('register')}}">Register</a>
        <a href="{{url('login')}}">Auth</a>
        <a href="{{url('logout')}}">LogOut</a>
    </body>
</html>