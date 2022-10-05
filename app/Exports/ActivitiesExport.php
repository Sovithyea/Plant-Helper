<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ActivitiesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Activity::with('crop')->get();
    }

    public function map($activity): array
    {
        return [
            $activity->id,
            $activity->name,
            $activity->stage_text,
            $activity->detail,
            $activity->crop->name,
            $activity->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Stage',
            'Detail',
            'Crop',
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
