<?php

namespace App\Exports;

use App\Models\Crop;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class CropsExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Crop::with('category')->get();
    }

    public function map($crop): array
    {
        return [
            $crop->id,
            $crop->name,
            $crop->harvest,
            $crop->expire,
            $crop->category->name,
            $crop->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Harvest (days)',
            'Expired (days)',
            'Category',
            'Create At'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event)
            {
                $event->sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
}
