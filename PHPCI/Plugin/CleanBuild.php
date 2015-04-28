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
use PHPCI\Model\Build;
use PHPCI\PluginInterface;

/**
 * Clean build Plugin
 *
 * Removes Composer related files and allows PHPCI users to clean up their build
 * directory. Useful as a precursor to copy_build.
 *
 * @author       Dan Cryer <dan@block8.co.uk>
 * @package      PHPCI
 * @subpackage   Plugins
 */
class CleanBuild implements PluginInterface
{
    protected $remove;
    protected $phpci;
    protected $build;

    /**
     * Standard Constructor
     *
     * $options['directory'] Output Directory. Default: %BUILDPATH%
     * $options['filename']  Phar Filename. Default: build.phar
     * $options['regexp']    Regular Expression Filename Capture. Default: /\.php$/
     * $options['stub']      Stub Content. No Default Value
     *
     * @param Builder $phpci
     * @param Build   $build
     * @param array   $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci        = $phpci;
        $this->build = $build;
        $this->remove       = isset($options['remove']) && is_array($options['remove']) ? $options['remove'] : array();
    }

    /**
     * {@inheritDocs}
     */
    public function execute()
    {
        $cmd = 'rm -Rf "%s"';
        if (IS_WIN) {
            $cmd = 'rmdir /S /Q "%s"';
        }
        $this->phpci->executeCommand($cmd, $this->phpci->buildPath . 'composer.phar');
        $this->phpci->executeCommand($cmd, $this->phpci->buildPath . 'composer.lock');

        $success = true;

        foreach ($this->remove as $file) {
            $ok = $this->phpci->executeCommand($cmd, $this->phpci->buildPath . $file);

            if (!$ok) {
                $success = false;
            }
        }

        return $success;
    }
}
