<?php

namespace App\Http\Controllers;

use App\Http\Requests\FastEventRequest;
use Illuminate\Http\Request;
use App\FastEvent;
use App\Event;

class FastEventController extends Controller
{
    public function store(Request $request){
        FastEvent::create($request->all());

        return response()->json(true);
    }

    public function delete(Request $request){

        FastEvent::where('id',$request->id)->delete();

        return response()->json(true);
    }

    public function update(FastEventRequest $FastEventRequest){

        // para comprobar los datos que se envian en la consola
        var_dump($FastEventRequest->all());
        $event = Event::where('id',$FastEventRequest->id)->first();

        $event->fill($FastEventRequest->all());

        $event->save();

        return response()->json(true);
    }

}
