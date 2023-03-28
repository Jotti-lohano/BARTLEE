<?php

namespace App\Core\Traits;

use App\Models\Challenge;
use Illuminate\Http\Response;

trait Downloadable
{

    protected function wordDownload($data, $request)
    {
        $fileName = time() . '-download.docx';

        $headers = array(
            "Content-type"        => "application/msword",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $wordTest = new \PhpOffice\PhpWord\PhpWord();
        $newSection = $wordTest->addSection();

        $newSection->addText('Date' . ',' . 'Title' . ',' . 'Type');
        foreach ($data as $task) {
            $newSection->addText($task->created_at->format('d/m/y') . ',  ' . ($request->type == 'medicine' ? 'Medicine Reminder' : 'Appointment Reminder') . ',  ' . ($request->type == 'medicine' ? 'Medicine' : 'Appointment'));
        }

        $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordTest, 'Word2007');
        try {
            $objectWriter->save(storage_path('Reports.docx'));
        } catch (\Exception $e) {
        }



        $file = storage_path('Reports.docx');

        return response()->download($file, $fileName, $headers);
    }

    protected function excelDownload($data, $request)
    {

        $fileName = time() . '-download.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );


        $columns = array('Date', 'Title', 'Type');

        $callback = function () use ($data, $columns, $request) {


            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $item) {

                fputcsv($file, array(
                    $item->created_at->format('d/m/y'),
                    $request->type == 'medicine' ? 'Medicine Reminder' : 'Appointment Reminder',
                    $request->type == 'medicine' ? 'Medicine' : 'Appointment',
                ));
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
