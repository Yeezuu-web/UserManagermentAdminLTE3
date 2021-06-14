<?php

namespace App\Imports;

use App\Models\File;
use Throwable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FileImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new File([
            'id' => $row['id'],
            'content_id' => $row['content_id'],
            'title_of_content' => $row['title_of_content'],
            // 'channels' => $row['channels'],
            // 'duration' => $row['duration'],
            'series_id' => $row['series_id'],
            // 'date_received' => $row['date_received'],
            // 'air_date' => $row['air_date'],
            'file_extension' => $row['file_extension'],
            'resolution' => $row['resolution'],
            'path' => $row['path'],
            'storage' => $row['storage'],
            // 'year' => $row['year'],
            'file_size' => $row['file_size'],
            'size_type' => $row['size_type'],
            'remark' => $row['remark'],
        ]);
    }

    public function onError(Throwable $error)
    {
        
    }
}
