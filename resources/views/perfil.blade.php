@extends('layouts.app')
@section('content')
    <div style="text-align: center;">
        <h1>Mi perfil de {{$user->rol}}:</h1>
        <form method="get" action="/perfil">
            @switch($user->rol)
                @case('Administrador')
                        <li>Nombre de usuario</li><input type='text' name='username' value="{{$user->name}}">
                        <li>Correo electrónico</li><input type='text' name='correo' value='{{$user->email}}'>
                        <li>Nombre</li><input type='text' name='nombre' value='{{$rol->name}}'>
                    @break
                @case('Profesor')
                        <li>Nombre de usuario</li><input type='text' name='username' value="{{$user->name}}">
                        <li>Correo electrónico</li><input type='text' name='correo' value='{{$user->email}}'>
                        <li>Nombre</li><input type='text' name='nombre' value='{{$rol->name}}'>
                        <li>Apellidos</li><input type='text' name='apellidos' value='{{$rol->surname}}'>
                        <li>Teléfono</li><input type='text' name='telef' value='{{$rol->telephone}}'>
                        <li>NIF</li><input type='text' name='nif' value='{{$rol->nif}}'>
                    @break
                @case('Alumno')
                        <li>Nombre de usuario</li><input type='text' name='username' value='{{$user->name}}'>
                        <li>Correo electrónico</li><input type='text' name='correo' value='{{$user->email}}'>
                        <li>Nombre</li><input type='text' name='nombre' value='{{$rol->name}}'>
                        <li>Apellidos</li><input type='text' name='apellidos' value='{{$rol->surname}}'>
                        <li>Teléfono</li><input type='text' name='telef' value='{{$rol->telephone}}'>
                        <li>NIF</li><input type='text' name='nif' value='{{$rol->nif}}'>
                        <h2>Notificaciones</h2>
                        <input type="checkbox" name="work" value='1'>trabajos<br>
                        <input type="checkbox" name="exam" value='1'>examenes<br>
                        <input type="checkbox" name="continuous_assessment" value='1'>evaluación continua<br>
                        <input type="checkbox" name="final_note" value='1'>nota final<br>
                    @break
            @endswitch
            <br>
            <br>
            {{csrf_field()}}
            <input type="submit" name="enviar" value="Enviar">
        </form>
    </div>
@endsection