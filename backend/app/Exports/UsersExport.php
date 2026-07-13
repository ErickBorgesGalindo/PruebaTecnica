<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select('code', 'email', 'name', 'phone', 'created_at')->get()->map(fn($item) => collect($item->toArray())->except('id')->toArray());
    }

    public function headings(): array
    {
        return ['Código', 'Usuario', 'Email', 'Teléfono', 'Fecha de Creación'];
    }
}