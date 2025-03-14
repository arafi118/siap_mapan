<?php

namespace App\Imports\import;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PaketImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        return $collection;
    }
}
