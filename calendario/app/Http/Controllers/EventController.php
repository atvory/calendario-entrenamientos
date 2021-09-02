<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Event;
//use Request;
use Illuminate\Http\Request;
use Facade\Ignition\QueryRecorder\Query;





class EventController extends Controller
{
    public function routeLoadEvents()
    {

        //recupera los eventos desde una semana antes de la fecha actual.
        $date = date('Y/m/d',strtotime("-1 week"));
        $events = Event::where('start', '>=', $date)->get();

        //$events = Event::all();   // trae todos los eventos
        //return response()->json($events);
        return json_encode($events);
    }

    public function store(EventRequest $EventRequest)
    {
        Event::create($EventRequest->all());

        return response()->json(true);
    }

    public function update(EventRequest $EventRequest)
    {
        // para comprobar los datos que se envian en la consola
        //var_dump($request->all());
        $event = Event::where('id',$EventRequest->id)->first();

        $event->fill($EventRequest->all());

        $event->save();

        return response()->json(true);
    }

    public function delete(request $request){

        Event::where('id',$request->id)->delete();

        return response()->json(true);
    }



}
