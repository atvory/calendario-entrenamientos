<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FastEvent extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['tutor_id','act_title','act_description','act_tipo','video'];
    
}
