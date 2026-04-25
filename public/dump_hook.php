<?php

// Logs requests + included PHP files for THIS project only.
// Turn on/off from this project .env: DUMP_HOOK=true|false

error_reporting(0);

$logDir = __DIR__ . '/__dump_logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0777, true);
}

$request = $_SERVER['REQUEST_URI'] ?? 'CLI';
$requestId = date('Ymd_His');
$requestSafe = preg_replace('/[^a-zA-Z0-9._-]+/', '_', $request);
$requestSafe = trim($requestSafe, '_');
if ($requestSafe === '') {
    $requestSafe = 'request';
}
$perRequestFile = $logDir . '/included_' . $requestId . '_' . $requestSafe . '.txt';
@file_put_contents(
    $logDir . '/requests.txt',
    date('Y-m-d H:i:s') . ' => ' . $request . PHP_EOL,
    FILE_APPEND
);

register_shutdown_function(function () use ($logDir, $perRequestFile, $request) {
    $err = error_get_last();
    if ($err) {
        @file_put_contents($logDir . '/errors.txt', print_r($err, true) . PHP_EOL, FILE_APPEND);
    }

    $included = get_included_files();
    @file_put_contents($logDir . '/included_files_full.txt', implode(PHP_EOL, $included));
    @file_put_contents(
        $perRequestFile,
        $request . PHP_EOL . str_repeat('=', 60) . PHP_EOL . implode(PHP_EOL, $included)
    );
});

// Initial snapshot (early in the request).
$included = get_included_files();
@file_put_contents($logDir . '/included_files.txt', implode(PHP_EOL, $included));

