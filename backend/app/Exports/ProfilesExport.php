<?php

namespace App\Exports;

use App\Models\Profile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfilesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Profile::select('code', 'name', 'created_at')->get()->map(fn($item) => collect($item->toArray())->except('id')->toArray());
    }

    public function headings(): array
    {
        return ['Código', 'Nombre', 'Fecha de Creación'];
    }
}