<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttandanceExport implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;
    protected $heads,$list;
    public function __construct($data)
    {
        $this->heads = $data[1];
        $this->list = $data[0];
    }
    public function collection()
    {
        
        //$results = Order::select('id', 'name', 'email', 'phone', 'address', 'extra_service', 'sub_total', 'total', 'payment_status', 'status', 'is_order_online')->whereIn('id',$this->month)->get();
        $data = $this->list;
        
        return collect($data);
    }

    public function headings(): array
    {
        $data = $this->heads;
        return [
            $data
        ];
    }
    public function title(): string
    {
        return 'Attandance Report';
    }
}
