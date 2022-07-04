<?php

namespace App\Exports\Report;

use App\Models\SalesDetail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReport implements FromQuery, WithMapping, WithHeadings, WithColumnWidths, WithStyles, WithHeadingRow
{
    use Exportable;

    public function __construct(string $start = null, string $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function query()
    {
        $query = SalesDetail::query();
        if ($this->start) {
            $query->where('created_at', '>=', $this->start);
        }
        if ($this->end) {
            $query->where('created_at', '<=', $this->end);
        }
        return $query;
    }

    public function map($sale): array
    {
        return [
            $sale->created_at->format('d/m/Y'),
            $sale->sales->invoice_number,
            $sale->sales->customer->name,
            $sale->product->name,
            $sale->product->price,
            $sale->quantity,
            $sale->product->price * $sale->quantity,
        ];
    }

    public function headings(): array
    {
        return [
            __('Date'),
            __('Invoice Number'),
            __('Customer'),
            __('Product'),
            __('Price'),
            __('Quantity'),
            __('Total'),
        ];
    }

    public function headingRow(): int
    {
        return 3;
    }

    public function columnWidths(): array
    {
        return [
            "A" => 10,
            "B" => 50,
            "C" => 10,
            "D" => 45,
            "E" => 8,
            "F" => 8,
            "G" => 8
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => [
                        'rgb' => Color::COLOR_WHITE
                    ]
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => Color::COLOR_BLUE],
                ],
                ''
            ],
        ];

    }


}
