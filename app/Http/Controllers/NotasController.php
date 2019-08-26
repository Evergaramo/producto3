<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class NotasController extends Controller
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
        $r=DB::select("select id from students where email=?", [$user->email]);
        foreach ($r as $s => $value) {
            $id=$value->id;
        }

        $cursos=array();
        $r=DB::select("select * from courses where id_course IN (select id_course from enrollment where id_student=?)", [$id]);
        foreach ($r as $s => $value) {
            array_push($cursos, $value);
        }

        $notas='';
        $exams='';
        $works='';
        $percentages='';
        $clases='';

        if(isset($_GET["curso"])){
            $notas=true;
            $exams=array();
            $works=array();
            $percentages=array();
            $clases=array();
            $r=DB::select("select * from exams where id_student=?", [$id]);
            foreach ($r as $s => $value) {
                array_push($exams, $value);
            }
            $r=DB::select("select * from works where id_student=?", [$id]);
            foreach ($r as $s => $value) {
                array_push($works, $value);
            }
            $r=DB::select("select * from percentage where id_course=? and id_course IN (select id_course from enrollment where id_student=?)", [$_GET["curso"], $id]);
            foreach ($r as $s => $value) {
                array_push($percentages, $value);
            }
            $r=DB::select("select * from class where id_course = ? AND id_course IN (select id_course from enrollment where id_student=?)", [$_GET["curso"], $id]);
            foreach ($r as $s => $value) {
                array_push($clases, $value);
            }
        }else{
            $notas=false;
        }

        return view("notas", compact('user', 'cursos', 'notas', 'exams', 'works', 'percentages', 'clases'));
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
