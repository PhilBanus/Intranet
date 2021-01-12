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
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LPT2TimeUserBulk implements FromView, WithEvents, WithTitle
{
	
	use Exportable;
	
	public $timer; 
	public $C_ID; 
	public $Name;
	public $Company;
	public $ID;

	 public function __construct(int $time, int $C_ID, $Name, $Company, $ID)
	{
		$this->timer = $time; 
		$this->C_ID = $C_ID; 
		$this->Name = $Name; 
		$this->Company = $Company; 
		$this->ID = $ID; 
	}
  
    public function view(): View
    {
        return view('LPTtwo.Time.TimeUserBulk', [
			'time' => $this->timer,
			'C_ID' => $this->C_ID,
			'Name' => $this->Name,
			'Company' => $this->Company,
			'ID' => $this->ID
		]);
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
				$event->sheet->getRowDimension('2')->setRowHeight(20);
				$event->sheet->getRowDimension('3')->setRowHeight(20);
				
				
                $cellRange = 'A1:O1'; // All headers
              
				$BrandStyle = [
					 'font' => [
        'bold' => true,
						 'size' => 14
    ],
   'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];
  $Sheet->getStyle($cellRange)->applyFromArray($BrandStyle);
				
				
				
				
				$HeaderStyle =
					[
					'font' => [
						'bold' => true,
						'size' => 11
					],
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'startColor' => [
            				'argb' => 'FFCECECE',
        					]
					]
				];
				$GreenStyle =
					[
					'font' => [
						'bold' => false,
						'size' => 11
					],
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'startColor' => [
            				'argb' => 'FFC6E0B4',
        					]
					]
				];
				
				$HeaderStyle2 =
					[
					'font' => [
						'bold' => true,
						'size' => 11
					],
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'startColor' => [
            				'argb' => 'FFCECECE',
        					]
					],
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['argb' => 'FF000000']
							]
						]
				];
				
				$Sheet->getStyle('A2:J2')->applyFromArray($HeaderStyle);
				$Sheet->getStyle('M2:O2')->applyFromArray($HeaderStyle);
				$Sheet->getStyle('A3')->applyFromArray($HeaderStyle);
				$Sheet->getStyle('J3')->applyFromArray($HeaderStyle);
				$Sheet->getStyle('N3')->applyFromArray($HeaderStyle);
				$Sheet->getStyle('G3')->applyFromArray($HeaderStyle);
				$Sheet->getStyle('K3')->applyFromArray($HeaderStyle);
				$Sheet->getStyle('K2:L2')->applyFromArray($GreenStyle);
				$Sheet->getStyle('L3:O3')->applyFromArray($GreenStyle);
				$Sheet->getStyle('A4:O5')->applyFromArray($HeaderStyle2);
				
				
				
				
				
				
				
				
            },
        ];
    }
	
	
	  public function title(): string
    {
        return $this->Name;
    }
}
?>