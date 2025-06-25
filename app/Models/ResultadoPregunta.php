<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoPregunta extends Model
{

     use HasFactory;

        protected $table = 'resultadospreguntas';
        protected $fillable = ['alumnoid','preguntaid','cursoid','temaid','institucionid','respuesta','tiempo','created_at','updated_at','is_deleted','is_actived','tiemporeforzamiento','isexamen'];
}
