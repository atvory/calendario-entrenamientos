<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entrenadores extends Model
{
    use SoftDeletes;
    protected $fillable = ['nombre', 'apodo', 'email', 'pass'];
}
