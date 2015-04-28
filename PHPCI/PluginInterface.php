<?php
/**
 * PHPCI - Continuous Integration for PHP
 *
 * @copyright    Copyright 2015, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 * @link         https://www.phptesting.org/
 */

namespace PHPCI;

use PHPCI\Plugin\Exception\PluginException;
use PHPCI\Plugin\Exception\PluginBinaryNotFoundException;

/**
 * PHPCI Plugin Interface
 *
 * Interface used by all build plugins.
 *
 * @author   Dan Cryer <dan@block8.co.uk>
 */
interface PluginInterface
{
    /**
     * Exeucte the plugin and return the execution success result.
     *
     * @return bool Plugin execution status result.
     * @throws PluginException
     * @throws PluginBinaryNotFoundException
     */
    public function execute();
}
