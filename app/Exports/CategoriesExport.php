<?php

namespace App\Exports;

use App\Models\Crop;
use App\Models\User;
use App\Models\Disease;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Condition;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class CategoriesExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents, WithDrawings, WithCustomStartCell
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return  Category::all();
        // dd($categories, $crops, $diseases, $conditions, $activities, $users);
        // return [$categories, $crops, $diseases, $conditions, $activities, $users];
        // $crops = Crop::all();
    }

    public function map($categories): array
    {
        return [
            $categories->id,
            $categories->name,
            $categories->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Create at'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event)
            {
                $event->sheet->getStyle('A8:C8')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Plant Helper Logo');
        $drawing->setPath(public_path('/images/plant_helper.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B3');

        return $drawing;

    }

    public function startCell(): string
    {
        return 'A8';
    }
}
