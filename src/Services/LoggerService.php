<?php

namespace Jobayer\LaravelAppUpdater\Services;

use Illuminate\Support\Facades\Log;

class LoggerService
{
    public static function log($message)
    {
        $logFile = storage_path('logs/updater.log');
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - $message" . PHP_EOL, FILE_APPEND);
    }
}
