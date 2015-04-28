<?php
/**
 * PHPCI - Continuous Integration for PHP
 *
 * @copyright    Copyright 2015, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 * @link         https://www.phptesting.org/
 */

namespace PHPCI\Plugin;

use PHPCI\Builder;
use PHPCI\Helper\Lang;
use PHPCI\Model\Build;
use PHPCI\PluginInterface;

/**
 * Atoum plugin
 *
 * Runs Atoum tests within a project.
 *
 * @author       Sanpi <sanpi@homecomputing.fr>
 * @author       André Cianfarani <acianfa@gmail.com>
 * @author       Dan Cryer <dan@block8.co.uk>
 * @package      PHPCI
 * @subpackage   Plugins
 */
class Atoum implements PluginInterface
{
    private $args;
    private $config;
    private $directory;

    /**
     * Set up the plugin, configure options, etc.
     *
     * @param Builder $phpci
     * @param Build $build
     * @param array $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci = $phpci;
        $this->build = $build;

        if (isset($options['executable'])) {
            $this->executable = $this->phpci->buildPath . DIRECTORY_SEPARATOR.$options['executable'];
        } else {
            $this->executable = $this->phpci->findBinary('atoum');
        }

        if (isset($options['args'])) {
            $this->args = $options['args'];
        }

        if (isset($options['config'])) {
            $this->config = $options['config'];
        }

        if (isset($options['directory'])) {
            $this->directory = $options['directory'];
        }
    }

    /**
     * {@inheritDocs}
     */
    public function execute()
    {
        $cmd = $this->executable;

        if ($this->args !== null) {
            $cmd .= " {$this->args}";
        }
        if ($this->config !== null) {
            $cmd .= " -c '{$this->config}'";
        }
        if ($this->directory !== null) {
            $dirPath = $this->phpci->buildPath . DIRECTORY_SEPARATOR . $this->directory;
            $cmd .= " -d '{$dirPath}'";
        }
        chdir($this->phpci->buildPath);
        $output = '';
        $status = true;
        exec($cmd, $output);

        if (count(preg_grep("/Success \(/", $output)) == 0) {
            $status = false;
            $this->phpci->log($output);
        }
        if (count($output) == 0) {
            $status = false;
            $this->phpci->log(Lang::get('no_tests_performed'));
        }

        return $status;
    }
}
