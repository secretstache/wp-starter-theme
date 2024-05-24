<?php

namespace App;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Composer\Script\Event;
use Composer\IO\IOInterface;

class ComposerScripts
{
    public static function postCreateProject(Event $event)
    {
        $io = $event->getIO();

        // Get the current working directory, which should be the project directory
        $projectDirectory = getcwd();

        // Extract the last part of the path as the directory name
        $themePublicPathName = basename($projectDirectory); // e.g. ssm2023, amd2024

        $companyName = $io->ask('<question>Please enter the Company Name: </question>', 'Secret Stache Media');
        $companyUrl  = $io->ask('<question>Please enter the Company URL: </question>', 'https://secretstache.com/');
        $agencyName  = $io->ask('<question>Please enter the Agency Name: </question>', 'Secret Stache Media');
        $agencyUrl   = $io->ask('<question>Please enter the Agency URL: </question>', 'https://secretstache.com/');
        $textDomain  = $io->ask('<question>Please enter the Text Domain: </question>', 'ssm');

        $repositoryUrl = $io->ask('<question>Please enter the Repository URL: </question>', 'https://github.com/secretstache/wp-starter-theme');
        $preevuuPath   = $io->ask('<question>Please enter the Prefix Preevuu Path [client-folder/project-code]: </question>', 'secretstache/ssmv4');

        $io->write('<comment>Setting up your project...</comment>');

        // setup static branch
        self::installStaticBoilerplate($event);
        self::updatePackagePrefixPath($io, $preevuuPath);
        self::pushStaticBoilerplate($event);

        // setup master branch
        self::updateReadme($io, $companyName, $repositoryUrl);
        self::updateThemeInfo($io, $companyName, $companyUrl, $agencyName, $agencyUrl, $textDomain);
        self::updateThemePublicPathName($io, $themePublicPathName);

        self::composerUpdate($io);
        self::installPackages($io);
        self::buildAssets($io);
        self::pushMasterBranch($event);
    }

    public static function installStaticBoilerplate(Event $event)
    {
        $io = $event->getIO();
        $io->write("<comment>Cloning the ssm-static-boilerplate repository...<comment>");

        self::runCommand(['git', 'checkout', '-b', 'static'], $io);

        self::runCommand(['git', 'clone', 'https://github.com/secretstache/ssm-static-boilerplate', 'static'], $io);

        // Remove the .git directory
        self::runCommand(['rm', '-rf', './static/.git'], $io);

        $io->write("<info>Complete.</info>");
    }

    private static function updatePackagePrefixPath(IOInterface $io, string $preevuuPath)
    {
        $filePath = './static/package.json';

        $io->write('<comment>Updating prefix in the package.json ...</comment>');

        try {
            if (!file_exists($filePath)) {
                throw new \Exception("package.json file does not exist.");
            }

            $fileContent = file_get_contents($filePath);
            if ($fileContent === false) {
                throw new \Exception("Unable to read package.json content.");
            }

            $search  = ['secretstache/ssmv4'];
            $replace = [$preevuuPath];

            // Replace all placeholders with actual values in a single call
            $fileContent = str_replace($search, $replace, $fileContent);

            // Attempt to write the updated README.md content
            if (file_put_contents($filePath, $fileContent) === false) {
                throw new \Exception("Failed to write updates to package.json");
            }

            $io->write("<info>Complete.</info>");
        } catch (\Exception $e) {
            $io->write('<error>' . $e->getMessage() . '</error>');
        }
    }

    public static function pushStaticBoilerplate(Event $event)
    {
        $io = $event->getIO();
        $io->write("<comment>Push the static to repository...<comment>");

        self::runCommand(['git', 'add', '.'], $io);

        self::runCommand(['git', 'commit', '-m', 'install SSM Static Boilerplate'], $io);

        self::runCommand(['git', 'push', '-u', 'origin', 'static'], $io);

        self::runCommand(['git', 'checkout', 'master'], $io);

        $io->write("<info>Complete.</info>");
    }

    private static function updateReadme(IOInterface $io, string $companyName, string $repositoryUrl)
    {
        $filePath = './README.md';

        $io->write('<comment>Updating README.md...</comment>');

        try {
            if (!file_exists($filePath)) {
                throw new \Exception("README.md file does not exist.");
            }

            $fileContent = file_get_contents($filePath);
            if ($fileContent === false) {
                throw new \Exception("Unable to read README.md content.");
            }

            $search  = ['COMPANY_NAME', 'REPOSITORY_URL'];
            $replace = [$companyName, $repositoryUrl];

            // Replace all placeholders with actual values in a single call
            $fileContent = str_replace($search, $replace, $fileContent);

            // Attempt to write the updated README.md content
            if (file_put_contents($filePath, $fileContent) === false) {
                throw new \Exception("Failed to write updates to README.md.");
            }

            $io->write("<info>Complete.</info>");
        } catch (\Exception $e) {
            $io->write('<error>' . $e->getMessage() . '</error>');
        }
    }

    private static function updateThemeInfo(
        IOInterface $io,
        string $companyName,
        string $companyUrl,
        string $agencyName,
        string $agencyUrl,
        string $textDomain
    ) {
        $filePath = './style.css';

        $io->write('<comment>Updating style.css...</comment>');

        try {
            if (!file_exists($filePath)) {
                throw new \Exception("style.css file does not exist.");
            }

            $fileContent = file_get_contents($filePath);
            if ($fileContent === false) {
                throw new \Exception("Unable to read style.css content.");
            }

            $search  = ['COMPANY_NAME', 'COMPANY_URL', 'AGENCY_NAME', 'AGENCY_URL', 'TEXT_DOMAIN'];
            $replace = [$companyName, $companyUrl, $agencyName, $agencyUrl, $textDomain];

            // Replace all placeholders with actual values in a single call
            $fileContent = str_replace($search, $replace, $fileContent);

            // Attempt to write the updated README.md content
            if (file_put_contents($filePath, $fileContent) === false) {
                throw new \Exception("Failed to write updates to README.md.");
            }

            $io->write("<info>Complete.</info>");
        } catch (\Exception $e) {
            $io->write('<error>' . $e->getMessage() . '</error>');
        }
    }

    private static function updateThemePublicPathName(IOInterface $io, string $themePublicPathName)
    {
        $filePath = './bud.config.js';

        $io->write('<comment>Updating bud.config.js...</comment>');

        try {
            if (!file_exists($filePath)) {
                throw new \Exception("bud.config.js file does not exist.");
            }

            $fileContent = file_get_contents($filePath);
            if ($fileContent === false) {
                throw new \Exception("Unable to read bud.config.js content.");
            }

            $search  = ['THEME_PUBLIC_PATH_NAME'];
            $replace = [$themePublicPathName];

            // Replace all placeholders with actual values in a single call
            $fileContent = str_replace($search, $replace, $fileContent);

            // Attempt to write the updated README.md content
            if (file_put_contents($filePath, $fileContent) === false) {
                throw new \Exception("Failed to write updates to bud.config.js");
            }

            $io->write("<info>Complete.</info>");
        } catch (\Exception $e) {
            $io->write('<error>' . $e->getMessage() . '</error>');
        }
    }

    private static function installPackages(IOInterface $io)
    {
        $io->write("<comment>Installing npm dependencies...<comment>");

        self::runCommand([
            'yarn',
            'install',
        ], $io);

        $io->write("<info>Complete.</info>");
    }

    private static function buildAssets(IOInterface $io)
    {
        $io->write("<comment>Building assets...</comment>");

        self::runCommand([
            'yarn',
            'build',
        ], $io, 360);

        $io->write("<info>Complete.</info>");
    }

    private static function composerUpdate(IOInterface $io)
    {
        $io->write("<comment>Start composer update and install...</comment>");

        self::runCommand(['composer', 'update'], $io, 360);
        self::runCommand(['composer', 'install'], $io, 360);

        $io->write("<info>Complete.</info>");
    }

    public static function pushMasterBranch(Event $event)
    {
        $io = $event->getIO();
        $io->write("<comment>Final stage...<comment>");

        self::runCommand(['git', 'add', '.'], $io);

        self::runCommand(['git', 'commit', '-m', 'update theme info'], $io);

        self::runCommand(['git', 'push', '-u', 'origin', 'master'], $io);

        $io->write("<info>Setup Complete.</info>");
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