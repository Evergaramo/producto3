<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Notas</title>

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
        @switch($notas)
            @case(true)
                @foreach($clases as $clase)
                    <h1>Clase: {{$clase->name}}</h1>
                    <h2>Examenes:</h2>
                    <table>
                      <tr>
                        <th>Nombre</th>
                        <th>Nota</th>
                      </tr>
                      @foreach($exams as $exam)
                        @if($exam->id_class==$clase->id_class)
                            <tr>
                                <td>{{$exam->name}}</td>
                                <td>{{$exam->mark}}</td>
                            </tr>
                        @endif
                      @endforeach
                    </table>
                    <h2>Trabajos:</h2>
                    <table>
                      <tr>
                        <th>Nombre</th>
                        <th>Nota</th>
                      </tr>
                      @foreach($works as $work)
                        @if($work->id_class==$clase->id_class)
                            <tr>
                                <td>{{$work->name}}</td>
                                <td>{{$work->mark}}</td>
                            </tr>
                        @endif
                      @endforeach
                    </table>
                    <h2>Evaluación continua:</h2>
                    <table>
                      <tr>
                        <th>Evaluación continua</th>
                        <th>Examenes</th>
                      </tr>
                      @foreach($percentages as $percentage)
                        @if($percentage->id_class==$clase->id_class)
                            <tr>
                                <td>{{$percentage->continuous_assessment}}</td>
                                <td>{{$percentage->exams}}</td>
                            </tr>
                        @endif
                      @endforeach
                    </table>
                @endforeach
            @case(false)
                    <h3>Selecciona curso:</h3>
                    <form method="get" action="/notas">
                        <select name="curso">
                        @foreach($cursos as $curso)
                            <option value="{{$curso->id_course}}">{{$curso->name}}</option>
                        @endforeach
                        </select>
                        {{csrf_field()}}
                        <p><input type="submit" value="Submit"></p>
                    </form>
                @break
        @endswitch
    </body>
</html>
