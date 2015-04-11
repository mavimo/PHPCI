<?php
/**
 * PHPCI - Continuous Integration for PHP
 *
 * @copyright    Copyright 2014, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 * @link         https://www.phptesting.org/
 */

namespace PHPCI\Helper;

use PHPCI\Helper\BaseCommandExecutor;
use SplFileInfo;

/**
 * Unix/Linux specific extension of the CommandExecutor class.
 *
 * @package PHPCI\Helper
 */
class UnixCommandExecutor extends BaseCommandExecutor
{
    /**
     * Uses 'which' to find a system binary by name.
     *
     * @param string $binary
     *
     * @return null|string
     */
    protected function findGlobalBinary($binary)
    {
        if ($this->executeCommand(array('which "%s"', $binary))) {
            return SplFileInfo($this->getLastOutput());
        }
    }
}
