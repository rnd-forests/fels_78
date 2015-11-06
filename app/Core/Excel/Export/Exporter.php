<?php

namespace FELS\Core\Excel\Export;

use Maatwebsite\Excel\Files\NewExcelFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class Exporter extends NewExcelFile
{
    /**
     * Export data to PDF format.
     *
     * @param $data
     */
    public function exportPdf($data)
    {
        $items = ($data instanceof LengthAwarePaginator)
            ? $data->getCollection()
            : $data;
        $writer = $this->createNewFile();
        $writer->sheet($this->getSheetName(), function ($sheet) use ($items) {
            $sheet->with($this->formatData($items));
            $this->formatSheet($sheet);
        });
        $writer->export('pdf');
    }

    /**
     * Set styling values for the sheet.
     *
     * @param $sheet
     */
    protected function formatSheet($sheet)
    {
        $sheet->setStyle(['font' => ['size' => 14]]);
        $sheet->setOrientation('landscape');
        $sheet->setAllBorders('thin');
    }

    /**
     * Format data before writing to sheet.
     *
     * @param \Illuminate\Database\Eloquent\Collection $data
     * @return array
     */
    abstract protected function formatData($data);

    /**
     * Get the sheet name.
     *
     * @return string
     */
    abstract protected function getSheetName();
}
