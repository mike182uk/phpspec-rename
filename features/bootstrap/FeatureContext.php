<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class FeatureContext implements Context, SnippetAcceptingContext
{
    const PHPSPEC_CONFIG_TEST = 'phpspec-test.yml';
    const TEST_DIR = '_test';

    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct()
    {
        $this->projectDir = realpath('./');
        $this->filesystem = new Filesystem();
    }

    /**
     * @Given :class exists
     */
    public function exists($class)
    {
        $descCmd = $this->buildCmd(sprintf('desc %s', $class));
        $runCmd = $this->buildCmd('run');
        $cmd = sprintf('%s && %s', $descCmd, $runCmd);

        $process = new Process($cmd);

        $process->setEnv(['SHELL_INTERACTIVE' => true]);
        $process->setInput('Y');
        $process->run();

        if ( ! $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    /**
     * @When I rename :srcClass to :targetClass
     */
    public function iRenameTo($srcClass, $targetClass)
    {
        $renameCmd = $this->buildCmd(sprintf('rename %s %s', $srcClass, $targetClass));

        $process = new Process($renameCmd);

        $process->run();

        if ( ! $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    /**
     * @Then :_class should exist
     */
    public function shouldExist($class)
    {
        expect(class_exists($class))->toBe(true);
    }

    /**
     * @Then :_class should not exist
     */
    public function shouldNotExist($class)
    {
        expect(class_exists($class))->toBe(false);
    }

    /**
     * @Transform :class
     * @Transform :srcClass
     * @Transform :targetClass
     */
    public function normalizeClass($class)
    {
        return str_replace('\\', '/', $class);
    }

    /**
     * @param string $cmd
     *
     * @return string
     */
    private function buildCmd($cmd)
    {
        $cmdPrefix = sprintf('%s/bin/phpspec', $this->projectDir);
        $cmdSuffix = sprintf('--config %s/%s', $this->projectDir, self::PHPSPEC_CONFIG_TEST);

        return sprintf('%s %s %s', $cmdPrefix, $cmd, $cmdSuffix);
    }

    /**
     * @beforeScenario
     */
    public function removeTestDir()
    {
        $this->filesystem->remove(self::TEST_DIR);
    }
}
