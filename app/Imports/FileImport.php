<?php

namespace App\Imports;

use App\Imports\import\DesaImport;
use App\Imports\import\InstalasiImport;
use App\Imports\import\PaketImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Importable;

class FileImport implements WithMultipleSheets
{
    use Importable;

    public function sheets(): array
    {
        return [
            'DESA' => new DesaImport(),
            'PAKET' => new PaketImport(),
            'INSTALASI' => new InstalasiImport()
        ];
    }
}
