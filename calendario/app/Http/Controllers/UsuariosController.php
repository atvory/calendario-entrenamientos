<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Usuarios;

class UsuariosController extends Controller
{
    public function store(Request $request){
        Usuarios::create($request->all());

        return response()->json(true);
    }
}
