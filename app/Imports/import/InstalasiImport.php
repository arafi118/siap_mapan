<?php

namespace App\Imports\import;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class InstalasiImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        return $collection;
    }
}
