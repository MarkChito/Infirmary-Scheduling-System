<?php
function writeToEnvFile($data)
{
    $envFile = __DIR__ . '/.env';

    $file = fopen($envFile, 'w');

    foreach ($data as $key => $value) {
        fwrite($file, "$key=$value\n");
    }

    fclose($file);
}

function readFromEnvFile()
{
    $envFile = __DIR__ . '/.env';

    if (!file_exists($envFile)) {
        return [];
    }

    $file = fopen($envFile, 'r');

    $data = [];

    while (($line = fgets($file)) !== false) {
        $parts = explode('=', trim($line), 2);

        if (count($parts) === 2) {
            $data[$parts[0]] = $parts[1];
        }
    }

    fclose($file);

    return $data;
}
