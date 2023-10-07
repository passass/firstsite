@extends('template.main')

@section('inblock')
    <h1 class="maintext">
        Здравствуйте!
        <p>
            Мы InfoPedia
        </p>
        <p>
            Мы нужны для передачи информации
        </p>
        <p>
            Здесь вы можете оставлять информации и делиться своим мнением
        </p>
        <p> 
            Советуем узнать <a href="{{ route('about') }}">о нас</a>
        </p>
    </h1>
@endsection