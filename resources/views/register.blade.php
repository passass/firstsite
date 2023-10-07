@extends('template.form')

@section('inblock')
    <form method="post">
        {{ csrf_field() }}
        <h2><center>Регистрация</center></h2>

        <input type="text" name="name" placeholder="name">

        <input type="text" name="email" placeholder="email"> 

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
        <p>
            <button type="submit">Подтвердить</button>
        </p>
        <p>
            <a href="{{ route('login') }}">Авторизироваться</a>
        </p>
    </form>
@endsection