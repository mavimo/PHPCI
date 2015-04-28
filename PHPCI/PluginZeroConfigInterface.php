<?php
/**
 * PHPCI - Continuous Integration for PHP
 *
 * @copyright    Copyright 2015, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 * @link         https://www.phptesting.org/
 */

namespace PHPCI;

use PHPCI\Model\Build;

/**
 * PHPCI Plugin Interface - Used by all build plugins.
 *
 * @author   Dan Cryer <dan@block8.co.uk>
 */
interface PluginZeroConfigInterface
{
    /**
     * Check if this plugin can be executed.
     *
     * @param  string  $stage   The current stage
     * @param  Builder $builder The plugin builder
     * @param  Build   $build   The current build
     * @return bool             Plugin execution result status.
     */
    public static function canExecute($stage, Builder $builder, Build $build);
}
