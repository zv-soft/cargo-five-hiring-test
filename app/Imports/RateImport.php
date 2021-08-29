<?php

namespace App\Imports;


use App\Models\Rate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RateImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rate([
            'origin'             => $row['pol'],
            'destination'        => $row['pod'],
            'currency'           => $row['curr'],
            'twenty'             => $row['20gp'],
            'forty'              => $row['40gp'],
            'fortyhc'            => $row['40hc'],
        ]);
    }

    public function rules(): array
    {
        return [
            'origin'        => 'required',
            'destination'   => 'required',
            'currency'      => 'required',
            'twenty'        => 'required',
            'forty'         => 'required',
            'fortyhc'       => 'required',
        ];
    }
}
