# Node In Php
The PHP instance of Project-Level Node JS. 

This library allows you to install node js on your project making it possible for you to use node js even when it is not installed in the system. Moreover, You can consume the power of node js, npm and npx commands with ease using a php class.

<!-- [Read Blog Post.](https://www.shade.codes/introducing-project-level-node-js/) -->

This project is a development of the [THIS](https://github.com/abhishek6262/NodePHP) project

## Installation
NodePHP is available on Packagist and installation via Composer is the recommended way to install NodePHP.

```
composer require yama/nodeinphp
```

## Examples
```
require_once "vendor/autoload.php";

// $environment = new \Yama\NodeInPhp\System\Environment('projectRootPath', 'binDirectoryPath');
$environment = new \Yama\NodeInPhp\System\Environment(__DIR__);

$npm = new \Yama\NodeInPhp\NPM($environment);

if (! $npm->exists()) {
    $npm->install();
}

if ($npm->packagesExists() && ! $npm->packagesInstalled()) {
    $response = $npm->installPackages();
    
    if ($response->statusCode() == '0') {
        echo "Packages successfully installed.";
    } else {
        echo "Failed to install the packages.";
    }
    
    print_r($response->output());
}
```

## Credits

- [Abhishek Prakash](https://github.com/abhishek6262)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.