<?php

namespace App\Http\Controllers;

use App\Usuarios;
use App\FastEvent;
use App\Entrenadores;
use Illuminate\Http\Request;

class FullCalendarController extends Controller
{
    public function index(){
        $entrenadores = Entrenadores::all();
        $usuarios = Usuarios::all();
        $fastEvents = FastEvent::all();
        
        //return view('fullcalendar.master', ['usuarios'=>$usuarios], ['fastEvents'=>$fastEvents]);
        return view('fullcalendar.master', ['usuarios'=>$usuarios,'fastEvents'=>$fastEvents,'entrenadores'=>$entrenadores]);
    }
}
