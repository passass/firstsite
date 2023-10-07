<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">

        <title>Register</title>
    </head>
    <body>

        <form action="{{route('register')}}" method="POST">
            {{ csrf_field() }}

            <input type="text" name="name" placeholder="name">

            <input type="text" name="email" placeholder="email"> 

            <input type="text" name="password" placeholder="password">

            <input type="submit" value="Submit">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </body>
</html>