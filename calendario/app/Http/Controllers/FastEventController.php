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

}
