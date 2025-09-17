<?php
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

$client = new ImageAnnotatorClient([
    'credentials' => __DIR__ . '/vision-key.json'
]);

echo "✅ Vision Client Loaded!";
$client->close();
