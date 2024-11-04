<?php

namespace App\Exports;

use App\Models\BatchProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;
    protected $id;
    public function __construct($data)
    {
        $this->id = $data;

    }

    public function collection()
    {
        return BatchProduct::select('code')->where('batch_id',$this->id)->get();
    }

    public function headings(): array
    {
        return [
            'Code'
        ];
    }
    public function title(): string
    {
        return 'Code';
    }
}
