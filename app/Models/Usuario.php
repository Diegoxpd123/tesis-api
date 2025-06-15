<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{

     use HasFactory;

        protected $table = 'usuarios';
        protected $fillable = ['usuario','contra','tipousuarioid','aludocenid','created_at','updated_at','is_deleted','is_actived'];
}
