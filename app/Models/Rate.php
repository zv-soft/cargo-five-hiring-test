<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    public $table = 'rates';

    public $fillable = [
        'origin',
        'destination',
        'currency',
        'twenty',
        'forty',
        'fortyhc',
        'contract_id'
    ];

    public static $rules = [
        'pol'       => 'required',
        'pod'       => 'required',
        'curr'      => 'required',
        '20gp'      => 'required',
        '40gp'      => 'required',
        '40hc'      => 'required',
    ];

    public static $messages = [
        'required'=>'El :attribute es requerido',
    ];
}
