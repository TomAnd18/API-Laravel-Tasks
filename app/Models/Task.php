<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    //relacion con la tabla
    protected $table = 'task';

    //campos que pueden ser modificados
    protected $fillable = [
        'tittle',
        'description',
        'tag',
        'deadline'
    ];
}
