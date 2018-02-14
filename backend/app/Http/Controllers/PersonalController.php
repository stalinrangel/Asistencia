<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personal=\App\Personal::get();
        $taller=(object) [ "entradaManana"=> "08:30:00",  "salidaManana"=> "12:00:00", "entradaTarde"=> "14:30:00", "salidaTarde"=> "19:00:00" ];
        $transporte=(object) [ "entradaManana"=> "08:00:00", "salidaManana"=> "12:00:00",  "entradaTarde"=> "14:00:00", "salidaTarde"=> "18:00:00" ];
        $yacimiento=(object) [ "entradaManana"=> "08:00:00", "salidaManana"=> "12:00:00", "entradaTarde"=> "14:00:00", "salidaTarde"=> "17:00:00" ];
        for ($i=0; $i < count($personal); $i++) { 
            if ($personal[$i]->tipo_horario=='taller') {
                $personal[$i]->horario=$taller;
            }else if ($personal[$i]->tipo_horario=='transporte') {
                $personal[$i]->horario=$transporte;
            }else{
                $personal[$i]->horario=$yacimiento;
            }
        }
        return $personal;
        
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
