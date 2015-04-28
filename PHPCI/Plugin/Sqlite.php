<?php
/**
 * PHPCI - Continuous Integration for PHP
 *
 * @copyright    Copyright 2015, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 * @link         https://www.phptesting.org/
 */

namespace PHPCI\Plugin;

use PDO;
use PHPCI\Builder;
use PHPCI\Model\Build;
use PHPCI\PluginInterface;

/**
 * SQLite Plugin — Provides access to a SQLite database.
 *
 * @author       Corpsee <poisoncorpsee@gmail.com>
 * @package      PHPCI
 * @subpackage   Plugins
 */
class Sqlite implements PluginInterface
{
    /**
     * @var \PHPCI\Builder
     */
    protected $phpci;

    /**
     * @var \PHPCI\Model\Build
     */
    protected $build;

    /**
     * @var array
     */
    protected $queries = array();

    /**
     * @var string
     */
    protected $path;

    /**
     * @param Builder $phpci
     * @param Build   $build
     * @param array   $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci   = $phpci;
        $this->build   = $build;
        $this->queries = $options;
        $buildSettings = $phpci->getConfig('build_settings');

        if (isset($buildSettings['sqlite'])) {
            $sql = $buildSettings['sqlite'];
            $this->path = $sql['path'];
        }
    }

    /**
     * {@inheritDocs}
     */
    public function execute()
    {
        try {
            $opts = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            $pdo = new PDO('sqlite:' . $this->path, $opts);

            foreach ($this->queries as $query) {
                $pdo->query($this->phpci->interpolate($query));
            }
        } catch (\Exception $ex) {
            $this->phpci->logFailure($ex->getMessage());
            return false;
        }
        return true;
    }
}
