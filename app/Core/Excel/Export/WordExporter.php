<?php

namespace FELS\Core\Excel\Export;

class WordExporter extends Exporter
{
    /**
     * Format data before writing to sheet.
     *
     * @param \Illuminate\Database\Eloquent\Collection $data
     * @return array
     */
    protected function formatData($data)
    {
        return $data->map(function ($word) {
            return [
                'Content' => $word->content,
                'Category' => $word->category->name,
                'Published Date' => full_time($word->created_at),
            ];
        })->toArray();
    }

    /**
     * Get exported file name.
     *
     * @return string
     */
    public function getFilename()
    {
        return uniqid('words-');
    }

    /**
     * Get the sheet name.
     *
     * @return string
     */
    protected function getSheetName()
    {
        return uniqid('sheet-');
    }
}
