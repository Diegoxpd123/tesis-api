<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{

     use HasFactory;

        protected $table = 'cursos';
        protected $fillable = ['nombre','institucionid','created_at','updated_at','is_deleted','is_actived'];
}
