<?php

namespace App\Http\Controllers;

use DB;

use App\Quotation;

use App\Admin;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

class PerfilController extends Controller
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
        $correo = $user->email;

        $rol=null;

        if(isset($_GET["username"]))
            $user->name=$_GET["username"];

        if($user->rol=='Administrador'){
            if(isset($_GET["correo"]))
            {
                DB::select("update users_admin set username = ?, name = ?, email = ? where email = ?", [$_GET['username'],$_GET['nombre'],$_GET['correo'],$user->email]);
                DB::select("update users set name = ?, email = ? where email = ?", [$_GET['username'],$_GET['correo'],$user->email]);
            }
            if(isset($_GET["correo"]))
                $r=DB::select("select * from users_admin where email=?", [$_GET['correo']]);
            else
                $r=DB::select("select * from users_admin where email=?", [$user->email]);
            foreach ($r as $s => $value) {
                $rol=$value;
            }
            if($rol==null){
                DB::select("insert into users_admin (username, name, email, password) values (?,?,?,?)", [$user->name,'',$user->email,$user->password]);
                $r=DB::select("select * from users_admin where email=?", [$user->email]);
                foreach ($r as $s => $value) {
                    $rol=$value;
                }
            }
        }
        elseif($user->rol=='Profesor'){
            if(isset($_GET["correo"]))
            {
                DB::select("update teachers set name = ?, surname = ?, email = ?, telephone = ?, nif = ? where email = ?", [$_GET['nombre'],$_GET['apellidos'],$_GET['correo'],$_GET['telef'],$_GET['nif'],$user->email]);
                DB::select("update users set name = ?, email = ? where email = ?", [$_GET['username'],$_GET['correo'],$user->email]);
            }
            if(isset($_GET["correo"]))
                $r=DB::select("select * from teachers where email=?", [$_GET['correo']]);
            else
                $r=DB::select("select * from teachers where email=?", [$user->email]);
            foreach ($r as $s => $value) {
                $rol=$value;
            }
            if($rol==null){
                DB::select("insert into teachers (name, surname, email, telephone, nif) values (?,?,?,?,?)", [$user->name,'',$user->email,'','']);
                $r=DB::select("select * from teachers where email=?", [$user->email]);
                foreach ($r as $s => $value) {
                    $rol=$value;
                }
            }
        }
        elseif ($user->rol=='Alumno') {
            if(isset($_GET["correo"]))
            {
                DB::select("update students set username = ?, name = ?, surname = ?, email = ?, telephone = ?, nif = ? where email = ?", [$_GET['username'],$_GET['nombre'],$_GET['apellidos'],$_GET['correo'],$_GET['telef'],$_GET['nif'],$user->email]);
                DB::select("update users set name = ?, email = ? where email = ?", [$_GET['username'],$_GET['correo'],$user->email]);
            }
            if(isset($_GET["correo"]))
                $r=DB::select("select * from students where email=?", [$_GET['correo']]);
            else
                $r=DB::select("select * from students where email=?", [$user->email]);
            foreach ($r as $s => $value) {
                $rol=$value;
            }
            if($rol==null){
                DB::select("insert into students (username, name, surname, email, pass, date_registered, telephone, nif) values (?,?,?,?,?,?,?,?)", [$user->name,'','',$user->email,$user->password,date($user->created_at),'','']);
                $r=DB::select("select * from students where email=?", [$user->email]);
                foreach ($r as $s => $value) {
                    $rol=$value;
                }
            }
            $id_student;
            $r=DB::select("select id from students where email=?", [$user->email]);
            foreach ($r as $s => $value) {
                $id_student=$value->id;
            }
            $r=DB::select("select id_student from notifications where id_student=?", [$id_student]);
            foreach ($r as $s => $value) {
                $id_student=$value->id_student;
            }
            if($id_student==null){
                $user->name=$id_student;
                DB::select("insert into notifications (id_student, work, exam, continuous_assessment, final_note) values (?,?,?,?,?)", [$id_student,0,0,0,0]);
            }
            if(isset($_GET["works"]) && isset($_GET["exam"]) && isset($_GET["continuous_assessment"]) && isset($_GET["final_note"])){
                DB::select("update notifications set work = ?, exam = ?, continuous_assessment = ?, final_note = ? where id_student=?", [$_GET["works"],$_GET["exam"],$_GET["continuous_assessment"],$_GET["final_note"],$id_student]);
            }
        }

        $datos=[
            "titulo"=>"Perfil actualizado",
            "contenido"=>"Hemos actualizado tu perfil"
        ];

        
        if(isset($_GET["correo"])){
            $user->email=$_GET["correo"];
            try{
                Mail::send("emails.test", $datos, function($mensaje){
                    $mensaje->to($_GET["correo"], "Usuario")->subject("Cambios en tu perfil");
                });
            } catch (\Swift_TransportException $e){
                echo $e->getMessage();
            }
        }

        return view('perfil', compact('user', 'rol'));
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
