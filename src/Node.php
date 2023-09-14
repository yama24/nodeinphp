<?php

namespace Yama\NodeInPhp;

use Yama\NodeInPhp\System\Environment;
use Yama\NodeInPhp\System\Response;

/**
 * Class Node
 * @package Yama\NodeInPhp
 */
class Node extends Environment
{
    /**
     * Determines whether Node has been installed in the project.
     *
     * @return bool
     */
    public function isNodeExist()
    {
        return $this->exists('node');
    }
    /**
     * Determines whether Npm has been installed in the project.
     *
     * @return bool
     */
    public function isNpmExist()
    {
        return $this->exists('npm');
    }
    /**
     * Determines whether Npx has been installed in the project.
     *
     * @return bool
     */
    public function isNpxExist()
    {
        return $this->exists('npx');
    }

    /**
     * Runs the raw node command.
     * 
     * @param  string $command
     * 
     * @return Response
     */
    public function node($command)
    {
        return $this->rawCommand('node ' . $command);
    }

    /**
     * Runs the raw npm command.
     * 
     * @param  string $command
     * 
     * @return Response
     */
    public function npm($command)
    {
        return $this->rawCommand('npm ' . $command);
    }

    /**
     * Runs the raw npx command.
     * 
     * @param  string $command
     * 
     * @return Response
     */
    public function npx($command)
    {
        return $this->rawCommand('npx ' . $command);
    }

    /**
     * Determines whether code has been installed in the project.
     *
     * @return bool
     */
    public function exists($code)
    {
        $bin = $this->getNodeBin();

        if (empty($bin)) {
            return false;
        } elseif (!file_exists($bin . '/' . $code)) {
            return false;
        }

        return true;
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

        exec(escapeshellcmd($command) . ' 2>&1', $message, $code);

        chdir($CURRENT_WORKING_DIRECTORY);

        return new Response($message, $code);
    }

    /**
     * Installs the packages present in the package.json file.
     *
     * @return Response
     */
    public function installPackages()
    {
        return $this->npm('install');
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
