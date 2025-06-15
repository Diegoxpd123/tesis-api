<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{

     use HasFactory;

        protected $table = 'alumnos';
        protected $fillable = ['nombre','numero','correo','seccionid','institucionid','created_at','updated_at','is_deleted','is_actived'];
}
