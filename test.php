<?php
require_once "vendor/autoload.php";
$environment = new \Yama\NodeInPhp\System\Environment(__DIR__);
$node = new \Yama\NodeInPhp\Node($environment);
if (!$node->exists()) {
    $node->install('16.20.0');
}
$npm = new \Yama\NodeInPhp\NPM($environment);
$npx = new \Yama\NodeInPhp\NPX($environment);

if ($npm->packagesExists() && !$npm->packagesInstalled()) {
    $response = $npm->installPackages();

    if ($response->statusCode() == '0') {
        echo "Packages successfully installed.";
    } else {
        echo "Failed to install the packages.";
    }

    print_r($response->output());
}

$response = $node->rawCommand('-v');

$node = 'Node Version: ' . PHP_EOL;
foreach ($response->output() as $line) {
    $node .= $line . PHP_EOL;
}
echo $node . PHP_EOL;

$response = $npm->rawCommand('-v');

$npm = 'NPM Version: ' . PHP_EOL;
foreach ($response->output() as $line) {
    $npm .= $line . PHP_EOL;
}
echo $npm . PHP_EOL;

$response = $npx->rawCommand('-v');

$npx = 'NPX Version: ' . PHP_EOL;
foreach ($response->output() as $line) {
    $npx .= $line . PHP_EOL;
}
echo $npx . PHP_EOL;