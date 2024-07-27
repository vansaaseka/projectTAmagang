<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\AjuanMagang;

class DataAjuanExport implements FromCollection
{
    protected $semester;
    protected $tahun;

    public function __construct($semester, $tahun)
    {
        $this->semester = $semester;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return AjuanMagang::where('semester', $this->semester)
                          ->where('tahun', $this->tahun)
                          ->get();
    }
}
