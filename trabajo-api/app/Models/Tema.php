<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{

     use HasFactory;

        protected $table = 'temas';
        protected $fillable = ['nombre','cursoid','created_at','updated_at','is_deleted','is_actived'];
}
