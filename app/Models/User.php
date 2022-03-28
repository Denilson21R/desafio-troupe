<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'last_name',
        'cpf',
        'email',
        'phone',
        'cep',
        'public_place',
        'district',
        'city',
        'uf',
    ];

    public $timestamps = false;
}
