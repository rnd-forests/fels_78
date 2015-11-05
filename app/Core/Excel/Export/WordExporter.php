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
                'Word ID' => $word->id,
                'Word Content' => $word->content,
                'Category' => $word->category->name,
                'Created at' => full_time($word->created_at),
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
        return uniqid('Words_');
    }

    /**
     * Get the sheet name.
     *
     * @return string
     */
    protected function getSheetName()
    {
        return uniqid('Word_sheet_');
    }
}
