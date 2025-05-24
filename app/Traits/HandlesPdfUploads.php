<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

trait HandlesPdfUploads
{
    public function handlePdfUpload($file, $directory)
    {
        // Cria ou recria o diretório
        if (Storage::directoryMissing($directory)) {
            Storage::makeDirectory($directory, 0755, true, true);
        }
        Storage::deleteDirectory($directory);
        Storage::makeDirectory($directory, 0755, true, true);

        // Gera nome aleatório
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(20) . '.pdf';
        $outputPath = storage_path('app/' . $directory . '/' . $filename);

        // Converte imagem ou move PDF
        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) {
            $this->convertImageToPdf($file->getRealPath(), $outputPath);
        } else {
            $file->storeAs($directory, $filename);
        }

        return $filename;
    }

    public function convertImageToPdf($imagePath, $outputPath)
    {
        $imageData = base64_encode(file_get_contents($imagePath));
        $mime = mime_content_type($imagePath);
        $base64Image = "data:$mime;base64,$imageData";

        $html = "<html><body style='margin:0;padding:0;'>
                    <img src='{$base64Image}' style='width:100%;height:auto;'>
                 </body></html>";

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output($outputPath, \Mpdf\Output\Destination::FILE);
    }
    public function deletePdfDirectory($directory)
    {
        if (Storage::directoryMissing($this->diretory)) {
            Storage::makeDirectory($this->diretory);
        }
        Storage::deleteDirectory($this->diretory);
        return false;
    }
}
