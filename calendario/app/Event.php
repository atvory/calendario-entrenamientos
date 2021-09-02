<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    use SoftDeletes;

    //protected $fillable = ['title','start','end','color','description']; //constructor sin ids
    protected $fillable = ['tutor_id','alumno_id','title','start','end','color','description']; // <<--- para cambiar ids al crear eventos

    //funciones para poder modificar los eventos
public function getStartAttribute($value)
{
    $dateStart = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d');
    $timeStart = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('H:i:s');

    return $this->start = ($timeStart == '00:00:00' ? $dateStart : $value);
}

public function getEndAttribute($value)
{
    $dateEnd = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d');
    $timeEnd = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('H:i:s');

    return $this->end = ($timeEnd == '00:00:00' ? $dateEnd : $value);
}


    
}
