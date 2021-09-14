<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FastEvent extends Model
{
    use SoftDeletes;
    //protected $fillable = ['act_title','act_description','start','end','color'];
    protected $fillable = ['tutor_id','act_title','act_description','act_tipo','act_nivel','video'];
    //protected $fillable = ['act_title','act_description'];
}
