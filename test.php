<?php
require_once "vendor/autoload.php";
$node = new \Yama\NodeInPhp\Node(__DIR__);
$node->nvmUse('16.20.0');

if ($node->packagesExists() && !$node->packagesInstalled()) {
    $response = $node->installPackages();

    if ($response->statusCode() == '0') {
        echo "Packages successfully installed.";
    } else {
        echo "Failed to install the packages.";
    }

    print_r($response->output());
}

$response = $node->node('-v');

$message = 'Node Version: ' . PHP_EOL;
foreach ($response->output() as $line) {
    $message .= $line . PHP_EOL;
}
echo $message . PHP_EOL;

$response = $node->npm('-v');

$message = 'NPM Version: ' . PHP_EOL;
foreach ($response->output() as $line) {
    $message .= $line . PHP_EOL;
}
echo $message . PHP_EOL;

$response = $node->npx('-v');

$message = 'NPX Version: ' . PHP_EOL;
foreach ($response->output() as $line) {
    $message .= $line . PHP_EOL;
}
echo $message . PHP_EOL;
