<?php

namespace App\Filament\Actions;

use Closure;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DownloadBulkAction extends BulkAction
{

  
    protected ?Closure $mutateRecordDataUsing = null;

    public static function getDefaultName(): ?string
    {
    
        return 'downloadBulk';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Download Bulk');
        $this->icon('heroicon-s-download');

        $this->mutateRecordDataUsing(function (array $data) {
            // Add any additional data mutation logic here if needed
            return $data;
        });

        $this->action(function ($records) {
            // $this->process(function ($records) {
                // Define the name and path for the temporary ZIP file
                $zipFileName = 'images_' . time() . '.zip';
                $zipPath = storage_path('app/public/' . $zipFileName);

                // Create a new ZIP file
                $zip = new ZipArchive;

                if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                    // Loop through each record to add images to the ZIP
                 
                    foreach ($records as $record) {
                        if ($record->file_path) {
                            $imagePath = $record->file_path;

                            // Adjust this to your image path
                            if (Storage::exists($imagePath)) {
                                // Add the image to the ZIP, using the basename as the file name within the ZIP
                                $zip->addFile(storage_path('app/' . $imagePath), basename($imagePath));
                            }
                        }
                    }

                    // Close the ZIP file after adding all images
                    $zip->close();

                    // Create a BinaryFileResponse
                    $response = response()->download($zipPath);

                    // Delete the ZIP file after sending the response
                    $response->deleteFileAfterSend(true);

                    // Return the response
                    return $response;
                } else {
                    // Handle the error scenario where the ZIP file couldn't be created
                    return $this->dangerBanner('Failed to create a ZIP file.');
                }
            });
        // });
    }

    public function mutateRecordDataUsing(?Closure $callback): static
    {
        $this->mutateRecordDataUsing = $callback;

        return $this;
    }
}
