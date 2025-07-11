<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{

     use HasFactory;

        protected $table = 'docentes';
        protected $fillable = ['nombre','numero','correo','institucionid','created_at','updated_at','is_deleted','is_actived'];
}
