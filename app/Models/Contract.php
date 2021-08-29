<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;


    public $table = 'contracts';

    public $fillable = [
        'name',
        'date',
    ];

    public static $rules = [
        'name'      => 'required',
        'date'      => 'required',
        'file'      => 'required',
    ];

    public static $messages = [
        'required'=>'El :attribute es requerido',
    ];

    /**
     * Un contrato puede tener muchas rutas.
     */
    public function rate()
    {
        return $this->hasMany(Rate::class);
    }
}
