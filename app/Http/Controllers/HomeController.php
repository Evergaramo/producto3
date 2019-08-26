<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
	    $user=Auth::user();

        if($user->rol=='Administrador'){
            $r=DB::select("select * from users_admin where email=?", [$user->email]);
            foreach ($r as $s => $value) {
                $rol=$value;
            }
            if($rol==null){
                DB::select("insert into users_admin (username, name, email, password) values (?,?,?,?)", [$user->name,'',$user->email,$user->password]);
            }
        }
        elseif($user->rol=='Profesor'){
            $r=DB::select("select * from teachers where email=?", [$user->email]);
            foreach ($r as $s => $value) {
                $rol=$value;
            }
            if($rol==null){
                DB::select("insert into teachers (name, surname, email, telephone, nif) values (?,?,?,?,?)", [$user->name,'',$user->email,'','']);
            }
        }
        elseif ($user->rol=='Alumno') {
            $r=DB::select("select * from students where email=?", [$user->email]);
            foreach ($r as $s => $value) {
                $rol=$value;
            }
            if($rol==null){
                DB::select("insert into students (username, name, surname, email, pass, date_registered, telephone, nif) values (?,?,?,?,?,?,?,?)", [$user->name,'','',$user->email,$user->password,date($user->created_at),'','']);
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
                DB::select("insert into notifications (id_student, work, exam, continuous_assessment, final_note) values (?,?,?,?,?)", [$id_student,0,0,0,0]);
            }
        }

        return view('home', compact('user'));
    }
}
