<?php

namespace Jobayer\LaravelAppUpdater\Services;

use ZipArchive;
use Illuminate\Support\Facades\File;

class FileManager
{

    // Comment Added
    protected $uploadDir = 'storage/app/uploads/';

    public function uploadAndExtract($file)
    {
        // Define upload directory (relative to storage/app)
        $this->uploadDir = 'uploads/';

        // Get the original file name
        $fileName = $file->getClientOriginalName();

        // Full file path relative to storage/app
        $filePath = $this->uploadDir . $fileName;

        // Store the uploaded file in the uploads directory
        $file->storeAs($this->uploadDir, $fileName);

        // Create a new ZipArchive instance
        $zip = new \ZipArchive;

        // Full storage path to the uploaded zip file
        $fullPath = storage_path('app/private/' . $filePath);

        if (!file_exists($fullPath)) {
            throw new \Exception('File not found at: ' . $fullPath);
        }
        // Open and extract the zip file
        if ($zip->open($fullPath) === true) {
            $zip->extractTo(base_path()); // Extract to the base path of the Laravel project
            $zip->close();
        } else {
            throw new \Exception('Zip extraction failed. Unable to open the zip file.');
        }

        return true;
    }

    public function compareAndUpdateFiles($sourcePath)
    {
        $files = File::allFiles($sourcePath);

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $destination = base_path($relativePath);
            if (!File::exists($destination) || md5_file($file->getPathname()) !== md5_file($destination)) {
                File::copy($file->getPathname(), $destination);
            }
        }
    }
}
