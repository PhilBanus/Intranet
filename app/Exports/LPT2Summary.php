<?php
namespace App\Exports;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LPT2Summary implements FromView, WithEvents
{
	
	use Exportable;

  
    public function view(): View
    {
        return view('LPTtwo.Time.UserSummary');
		exit();
    }
	
	/**
     * @return array
     */
   
	   public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
				
				$Sheet =  $event->sheet->getDelegate();
				$event->sheet->getDefaultRowDimension()->setRowHeight(20);
				$event->sheet->getRowDimension('1')->setRowHeight(20);
				$event->sheet->freezePane('B1');

				foreach(range('A',$event->sheet->getHighestColumn()) as $columnID) {
   $event->sheet->getColumnDimension($columnID)
        ->setAutoSize(true);
}
	
				$BrandStyle = [
					 'font' => [
        'bold' => true,
						 'size' => 11,
						 'color' => ['argb' => 'FFFFFFFF'],
						 'wrapText' => false,
						 'autoSize' => true,
    ],
   'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];
  $event->sheet->getStyle('A1:'.$event->sheet->getHighestColumn().'1')->applyFromArray($BrandStyle);
				
					
				
$event->sheet->getStyle('A1:'.$event->sheet->getHighestColumn().($event->sheet->getHighestRow()-1))
	->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$event->sheet->getStyle('A1:'.$event->sheet->getHighestColumn().($event->sheet->getHighestRow()-1))
	->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$event->sheet->getStyle('A1:'.$event->sheet->getHighestColumn().($event->sheet->getHighestRow()-1))
	->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$event->sheet->getStyle('A1:'.$event->sheet->getHighestColumn().($event->sheet->getHighestRow()-1))
	->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
					
	
				
            },
        ];
    }
}
?>