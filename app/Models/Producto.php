<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
     use HasFactory;

        protected $table = 'productos';
        protected $fillable = ['talla','color','nombre','descripcion','stock','price_mayor','price','image','is_deleted','is_actived','created_at','updated_at'];

}
