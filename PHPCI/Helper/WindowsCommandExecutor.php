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

/**
 * Windows-specific extension of the CommandExecutor class.
 *
 * @package PHPCI\Helper
 */
class WindowsCommandExecutor extends BaseCommandExecutor
{
    /**
     * Use 'where' on Windows to find a binary, rather than 'which'.
     *
     * @param string $binary
     *
     * @return null|string
     */
    protected function findGlobalBinary($binary)
    {
        if ($this->executeCommand(array('where "%s"', $binary))) {
            return $this->getLastOutput();
        }
    }
}
