<?php

namespace Yama\NodeInPhp;

use Yama\NodeInPhp\System\Environment;
use Yama\NodeInPhp\System\Response;

/**
 * Class NPM
 * @package Yama\NodeInPhp
 */
class NPM
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var string
     */
    protected $rootPath;

    /**
     * NPM constructor.
     * 
     * @param  Environment $environment
     * @param  string $rootPath
     */
    public function __construct(Environment $environment, $rootPath = null)
    {
        $this->environment = $environment;
        $this->rootPath    = $rootPath;

        if (empty($this->rootPath)) {
            $this->rootPath = $this->environment->rootPath;
        }
    }

    /**
     * Determines whether NPM has been installed in the project.
     *
     * @return bool
     */
    public function exists()
    {
        $bin = $this->environment->getNodeBin();

        if (empty($bin)) {
            return false;
        } elseif (! file_exists($bin . '/npm')) {
            return false;
        }

        return true;
    }

    /**
     * Installs node environment in the project.
     * 
     * @param  string $version version of node to install. (e.g. 10.15.3)
     *
     * @return void
     *
     * @throws \Exception
     */
    public function install($version)
    {
        $this->environment->install($version);
    }

    /**
     * Installs the packages present in the package.json file.
     *
     * @return Response
     */
    public function installPackages()
    {
        return $this->rawCommand('install');
    }

    /**
     * Runs the raw npm command.
     * 
     * @param  string $command
     * 
     * @return Response
     */
    public function rawCommand($command)
    {
        $CURRENT_WORKING_DIRECTORY = getcwd();

        chdir($this->rootPath);

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);

        exec( escapeshellcmd('npm ' . $command) . ' 2>&1', $message, $code );

        chdir($CURRENT_WORKING_DIRECTORY);

        return new Response($message, $code);
    }

    /**
     * Determines whether the project has packages to be installed.
     *
     * @return bool
     */
    public function packagesExists()
    {
        return file_exists($this->rootPath . '/package.json') ? true : false;
    }

    /**
     * Determines whether the packages are already installed in the
     * project.
     *
     * @return bool
     */
    public function packagesInstalled()
    {
        return file_exists($this->rootPath . '/node_modules/') ? true : false;
    }
}