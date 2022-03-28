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

    public function fillWithCpfData($dados_cep) :void
    {
        $this->cep = $dados_cep->cep;
        $this->public_place = $dados_cep->logradouro;
        $this->district = $dados_cep->bairro;
        $this->city = $dados_cep->localidade;
        $this->uf = $dados_cep->uf;
    }
}
