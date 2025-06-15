<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{

     use HasFactory;

        protected $table = 'evaluaciones';
        protected $fillable = ['nombre','temaid','institucionid','created_at','updated_at','is_deleted','is_actived'];
}
