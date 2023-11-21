<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    // protected $primaryKey = 'id';
    // public $incrementing = true;
    // protected $keyType = 'number';
    protected $fillable = [
        // 'id',
        'cpf',
        'name',
        'surname',
        'birthdate',
        'email',
        'gender',
        // 'created_at',
        // 'updated_at'
    ];
}
