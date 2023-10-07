@extends('template.form')

@section('inblock')
    <form method="post">
        {{ csrf_field() }}
        <h2><center>Авторизация</center></h2>

        <input type="text" name="name" placeholder="name">

        <input type="text" name="password" placeholder="password">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="remember_me">Запомнить</label>
        <p>
            <button type="submit">Подтвердить</button>
        </p>
        <p>
            <a href="{{ route('register') }}">Регистрация</a>
        </p>
    </form>
@endsection