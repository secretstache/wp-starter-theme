<?php

namespace App;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Composer\Script\Event;
use Composer\IO\IOInterface;

class ComposerScripts
{
    public static function setupStaticBoilerplate(Event $event)
    {
        $io = $event->getIO();
        $io->write("<comment>Cloning the ssm-static-boilerplate repository...<comment>");

        self::runCommand(['git', 'checkout', '-b', 'static'], $io);

        self::runCommand(['git', 'clone', 'https://github.com/secretstache/ssm-static-boilerplate', 'static'], $io);

        // Remove the .git directory
        self::runCommand(['rm', '-rf', './static/.git'], $io);

        $io->write("<info>Complete.</info>");
    }

    private static function runCommand(array $command, IOInterface $io, $timeoutInSeconds = 60)
    {
        $process = new Process($command);
        $process->setTimeout($timeoutInSeconds);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            $io->write("<error>Error executing " . implode(" ", $command) . ": " . $exception->getMessage() . "</error>");
            die;
        }
    }
}