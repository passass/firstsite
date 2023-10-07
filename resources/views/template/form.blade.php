<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Название</title>
    <link href="{{ asset('css/template/form.css') }}" rel="stylesheet">
</head>
<body>
    <div class="flexbox">
        <div class="div__">
            <div class="div__form">
                @yield('inblock')
            </div>
        </div>
    </div>
    @yield('content')
</body>
</html>