<?php

/**
 * PHPCI - Continuous Integration for PHP.
 *
 * @copyright    Copyright 2015, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 *
 * @link         https://www.phptesting.org/
 */

namespace PHPCI\Plugin;

use PHPCI\Builder;
use PHPCI\Helper\BuildInterpolator;
use PHPCI\Helper\CommandExecutor;
use PHPCI\Model\Build;

/**
 * Asbtract plugin which uses a BuildInterpolator.
 */
abstract class AbstractInterpolatingPlugin extends AbstractExecutingPlugin
{
    /**
     * @var BuildInterpolator
     */
    protected $interpolator;

    /** Standard constructor.
     *
     * @param Builder $phpci
     * @param Build $build
     * @param BuildLogger $logger
     * @param CommandExecutor $executor
     * @param BuildInterpolator $interpolator
     * @param array $options
     */
    public function __construct(
        Builder $phpci,
        Build $build,
        BuildLogger $logger,
        CommandExecutor $executor,
        BuildInterpolator $interpolator,
        array $options = array()
    ) {
        $this->interpolator = $interpolator;
        parent::__construct($phpci, $build, $logger, $executor, $options);
    }
}