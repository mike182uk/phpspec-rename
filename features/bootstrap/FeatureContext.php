<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\Process\Process;

class FeatureContext implements Context, SnippetAcceptingContext
{
    const PHPSPEC_CONFIG_TEST = 'phpspec-test.yml';

    /**
     * @var string
     */
    private $projectDir;

    public function __construct()
    {
        $this->projectDir = realpath('./');
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
     * @Then :arg1 should exist
     */
    public function shouldExist($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then :arg1 should not exist
     */
    public function shouldNotExist($arg1)
    {
        throw new PendingException();
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
}
