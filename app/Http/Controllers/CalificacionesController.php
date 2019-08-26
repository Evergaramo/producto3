<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

class CalificacionesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user=Auth::user();

        $id='';
        $r=DB::select("select id_teacher from teachers where email=?", [$user->email]);
        foreach ($r as $s => $value) {
            $id=$value->id_teacher;
        }

        $fase=1;
        $cursos='';
        $clases='';
        $alumnos='';
        if(isset($_GET["curso"])){
            $fase=2;
            $clases=array();
            $r=DB::select("select * from class where id_course = ?", [$_GET["curso"]]);
            foreach ($r as $s => $value) {
                array_push($clases, $value);
            }
            $alumnos=array();
            $r=DB::select("select * from students where id IN (select id_student from enrollment where id_course = ?)", [$_GET["curso"]]);
            foreach ($r as $s => $value) {
                array_push($alumnos, $value);
            }
        }
        if(isset($_GET["clase"]) && isset($_GET["alumno"]) && isset($_GET["tipo"]) && isset($_GET["nombre"]) && isset($_GET["nota"])){
            $fase=4;
            $tipo=$_GET["nota"];
            $clase=$_GET["clase"];
            $alumno=$_GET["alumno"];
            $name=$_GET["nombre"];
            $nota=$_GET["nota"];
            $curso=null;
            $r=DB::select("select id_course from class where id_class = ?", [$clase]);
            foreach ($r as $s => $value) {
                $curso=$value->id_course;
            }
            if($tipo==1){
                DB::select("insert into exams (id_class, id_student, name, mark) values (?, ?, ?, ?)", [$clase, $alumno, $name, $nota]);
                $fase=3;

                DB:select("select * from percentage where id_course = ? and id_class = ?", [$curso, $clase]);
                $examenes=null;
                foreach ($r as $s => $value) {
                    $rol=$value;
                    $examenes=$value->exams;
                    $eval_cont=$value->continuous_assessment;
                }
                if($rol==null){
                    DB::select("insert into percentage (id_course, id_class, continuous_assessment, exams) values (?,?,?,?)", [$curso,$clase,$nota,1]);
                }
                else{
                    DB::update("update percentage set continuous_assessment = ?, exams = ? where id_course = ? and id_class = ?", [((($percentage+$examenes)+$nota)/($examenes+1)),$examenes+1,$curso,$clase]);
                }

                $datos=[
                    "titulo"=>"Examen calificado",
                    "contenido"=>"Tu examen de " . $name . " ha sido calificado con nota de " . $nota
                ];
            }
            else if($tipo==2){
                DB::select("insert into works (id_class, id_student, name, mark) values (?, ?, ?, ?)", [$clase, $alumno, $name, $nota]);
                $fase=3;

                $datos=[
                    "titulo"=>"Trabajo calificado",
                    "contenido"=>"Tu trabajo de " . $name . " ha sido calificado con nota de " . $nota
                ];
            }

            $email;
            $r=DB::select("select email from students where id = ?", [$alumno]);
            foreach ($r as $s => $value) {
                $email=$value->email;
            }

            if(isset($datos)){
                try{
                    Mail::send("emails.test", $datos, function($mensaje){
                        $mensaje->to($email, "Usuario")->subject("Nuevas calificaciones");
                    });
                } catch (\Swift_TransportException $e){
                    echo $e->getMessage();
                }
            }

        }
        if($fase==1){
            $cursos=array();
            $r=DB::select("select * from courses where id_course IN (select id_course from class where id_teacher IN (select id_teacher from teachers where id_teacher =?))", [$id]);
            foreach ($r as $s => $value) {
                array_push($cursos, $value);
            }
        }

        return view("calificaciones", compact('fase', 'cursos', 'clases', 'alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
