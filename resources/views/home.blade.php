@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Bienvenido {{$user->name}}

                    <br><br>

                    @switch($user->rol)
                        @case('Administrador')
                                <a href="https://phpmyadmin.test" target="_blank">Acceder a PhpMyAdmin</a>
                            @break
                        @case('Profesor')
                                <a href="calendario" target="_blank">Acceder al calendario</a>
                                <br><br>
                                <a href="calificaciones" target="_blank">Calificaciones</a>
                            @break
                        @case('Alumno')
                                <a href="calendario" target="_blank">Acceder al calendario</a>
                                <br><br>
                                <a href="notas" target="_blank">Ver notas</a>
                            @break
                    @endswitch
                    <br><br>
                    <a href="perfil" target="_blank">Perfil</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
