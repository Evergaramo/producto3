<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
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

        $stmt=DB::select("SELECT A.name, A.color, B.time_start, B.time_end, B.day 
                                FROM class A, schedule B 
                                WHERE 
                                    A.id_class = B.id_class 
                                AND 
                                    A.id_course IN 
                                        (SELECT id_course 
                                         FROM courses 
                                         WHERE id_course IN 
                                            (SELECT id_course 
                                             FROM enrollment
                                             WHERE id_student IN (
                                                SELECT id_student 
                                                FROM students
                                                WHERE email = ?)
                                            )
                                        )",
                                        [$user->email]
                                );
                                
        

        $myJson = "{'clases':[";

        foreach ($stmt as $s => $value) {
            $myJson =  $myJson . json_encode($value) . ','; // Parse to JSON and print.
        }
        
        $myJson = trim($myJson, ',');
        $myJson = $myJson . "]}";

        return view('calendario', compact('myJson')); 
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
