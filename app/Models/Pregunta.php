<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{

     use HasFactory;

        protected $table = 'preguntas';
        protected $fillable = ['descripcion','evaluacionid','imagen','respuesta','opcion1','opcion2','opcion3','opcion4','created_at','updated_at','is_deleted','is_actived'];
}
