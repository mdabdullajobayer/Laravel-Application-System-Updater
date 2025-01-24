<?php

namespace Jobayer\LaravelAppUpdater\Http\Controllers;

use Illuminate\Http\Request;
use Jobayer\LaravelAppUpdater\Services\LoggerService;
use Jobayer\LaravelAppUpdater\Services\FileManager;
use Jobayer\LaravelAppUpdater\Services\DatabaseManager;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controller;

class UpdaterController extends Controller
{
    public function index()
    {
        return view('Jobayer.SystemUpdater.uploader');
    }

    public function processUpdate(Request $request)
    {
        $request->validate([
            'update_file' => 'required|mimes:zip',
        ]);

        $fileManager = new FileManager();
        $databaseManager = new DatabaseManager();
        $extractionDir = base_path('public/uploads/extracted');
        $olddatabaseDir = base_path('database/update-schema.sql');
        try {
            if (file_exists($extractionDir)) {
                File::deleteDirectory($extractionDir);
            }
            if (file_exists($olddatabaseDir)) {
                File::delete($olddatabaseDir);
            }
            $fileManager->uploadAndExtract($request->file('update_file'));
            if (!is_dir($extractionDir)) {
                mkdir($extractionDir, 0755, true);
            }
            $fileManager->compareAndUpdateFiles(base_path('public/uploads/extracted'));
            if (file_exists(base_path('database/update-schema.sql'))) {
                $databaseManager->executeSQLFromFile(base_path('database/update-schema.sql'));
            }
            LoggerService::log('Update successful.');
            return response()->json(['status' => 'success', 'message' => 'Update successful.']);
        } catch (\Exception $e) {
            LoggerService::log('Update failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }
}
