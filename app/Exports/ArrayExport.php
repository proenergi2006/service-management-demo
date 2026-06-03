<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ArrayExport implements FromArray
{
    protected $data;

    public function __construct($headers, $rows)
    {
        $this->data = [
            $headers,
            ...$rows
        ];
    }

    public function array(): array
    {
        return $this->data;
    }
}