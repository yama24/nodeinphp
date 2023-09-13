<?php

namespace Yama\NodeInPhp;

use Yama\NodeInPhp\System\Environment;
use Yama\NodeInPhp\System\Response;

/**
 * Class Node
 * @package Yama\NodeInPhp
 */
class Node
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
     * Node constructor.
     * 
     * @param  Environment $environment
     * @param  string $rootPath
     */
    public function __construct(Environment $environment, $rootPath = '')
    {
        $this->environment = $environment;
        $this->rootPath    = $rootPath;

        if (empty($this->rootPath)) {
            $this->rootPath = $this->environment->rootPath;
        }
    }

    /**
     * Determines whether node has been installed in the project.
     *
     * @return bool
     */
    public function exists()
    {
        $bin = $this->environment->getNodeBin();

        if (empty($bin)) {
            return false;
        } elseif (! file_exists($bin . '/node')) {
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
     * Runs the raw node command.
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

        exec( escapeshellcmd('node ' . $command) . ' 2>&1', $message, $code );

        chdir($CURRENT_WORKING_DIRECTORY);

        return new Response($message, $code);
    }
}