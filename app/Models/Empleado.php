<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
      use HasFactory;

        protected $table = 'empleado';
        protected $fillable = ['dni','name','cargo','created_at','updated_at'];

}
