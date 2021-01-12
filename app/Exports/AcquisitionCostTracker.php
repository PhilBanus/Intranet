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
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AcquisitionCostTracker implements FromView, WithEvents, ShouldAutoSize
{
	
	use Exportable;

  
    public function view(): View
    {
        return view('Acq.Time.exceldash');

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
				$event->sheet->freezePane('G1');

	
							$G1 = [
					 'font' => [
        'bold' => true,
						 'size' => 15,
						 'color' => ['argb' => 'FFFFFFFF'],
						 'wrapText' => false,
						 'autoSize' => true,
    ],
   'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];
							$A1 = [
   'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];
  $event->sheet->getStyle('G1')->applyFromArray($G1);
  $event->sheet->getStyle('A1')->applyFromArray($A1);
				
	
	
						

				
            },
        ];
    }
}
?>