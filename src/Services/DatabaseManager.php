<?php

namespace Jobayer\LaravelAppUpdater\Services;

use Exception;
use Illuminate\Support\Facades\DB;

class DatabaseManager
{
    public function executeSQLFromFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception("SQL file not found at: $filePath");
        }
        $queries = file_get_contents($filePath);
        if (empty($queries)) {
            return new Exception("SQL query is empty!");
        }
        DB::unprepared($queries);
    }
}
