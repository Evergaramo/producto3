<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Calificaciones</title>

        <style>
        body {
            border: solid 1px grey;
            padding: 2% 25%;
            margin: 2% 12.5%;
        }
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }

        tr:nth-child(even) {
          background-color: #dddddd;
        }
        </style>
        
    </head>
    <body>
        @switch($fase)
            @case(1)
                    <h3>Selecciona curso:</h3>
                    <form method="get" action="/calificaciones">
                        <select name="curso">
                        @foreach($cursos as $curso)
                            <option value="{{$curso->id_course}}">{{$curso->name}}</option>
                        @endforeach
                        </select>
                        {{csrf_field()}}
                        <p><input type="submit" value="Submit"></p>
                    </form>
                @break
            @case(2)
                    <h3>Clase:</h3>
                    <form method="get" action="/calificaciones">
                        <select name="clase">
                        @foreach($clases as $clase)
                            <option value="{{$clase->id_class}}">{{$clase->name}}</option>
                        @endforeach
                        </select>

                        <h3>Alumno:</h3>
                        <select name="alumno">
                        @foreach($alumnos as $alumno)
                            <option value="{{$alumno->id}}">{{$alumno->name}}</option>
                        @endforeach
                        </select>

                        <h3>Tipo:</h3>
                        <select name="tipo">
                            <option value=1>examen</option>
                            <option value=2>trabajo</option>
                        </select>

                        <h3>Nombre:</h3>
                        <input type="text" name="nombre">

                        <h3>Nota:</h3>
                        <select name="nota">
                            @for($i=0; $i<11; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>

                        {{csrf_field()}}
                        <p><input type="submit" value="Submit"></p>
                    </form>
                @break
            @case(3)
                    Nota introducida.
                    <br><br>
                    <a href="/calificaciones">Introducir otra nota</a>
                @break
            @case(4)
                Ha ocurrido un error.
                <br><br>
                <a href="/calificaciones">Prueba de nuevo</a>
            @break
        @endswitch
    </body>
</html>
