<?php

namespace App\Exports;

use App\Models\Disease;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DiseasesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Disease::with('crop')->get();
    }

    public function map($disease): array
    {
        return [
            $disease->id,
            $disease->name,
            $disease->diagnosis,
            $disease->cause,
            $disease->solution,
            $disease->crop->name,
            $disease->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Diagnosis',
            'Cause',
            'Solution',
            'Crop',
            'Create At'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event)
            {
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
}
