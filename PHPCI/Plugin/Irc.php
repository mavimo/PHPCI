<?php
/**
 * PHPCI - Continuous Integration for PHP
 *
 * @copyright    Copyright 2014, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 * @link         https://www.phptesting.org/
 */

namespace PHPCI\Plugin;

use PHPCI\Helper\Lang;

/**
 * IRC Plugin - Sends a notification to an IRC channel
 * @author       Dan Cryer <dan@block8.co.uk>
 * @package      PHPCI
 * @subpackage   Plugins
 */
class Irc extends AbstractInterpolatingPlugin
{
    protected $message;
    protected $server;
    protected $port;
    protected $room;
    protected $nick;

    /**
     * Configure the plugin.
     *
     * @param array $options
     */
    protected function setOptions(array $options)
    {
        $this->message = $options['message'];
    }

    /**
     * {@inheritdoc}
     */
    protected function setCommonSettings(array $settings)
    {
        parent::setCommonSettings($settings);

        if (!isset($settings['server'], $settings['room'], $settings['nick'])) {
            throw new \Exception(Lang::get('irc_settings'));
        }

        $this->server = $settings['server'];
        $this->port = isset($settings['port']) ? $settings['port'] : 6667;
        $this->room = $settings['room'];
        $this->nick = $settings['nick'];
    }

    /**
     * Run IRC plugin.
     * @return bool
     */
    public function execute()
    {
        $msg = $this->interpolator->interpolate($this->message);

        $sock = fsockopen($this->server, $this->port);
        fputs($sock, 'USER ' . $this->nick . ' phptesting.org ' . $this->nick . ' :' . $this->nick . "\r\n");
        fputs($sock, 'NICK ' . $this->nick . "\r\n");
        fputs($sock, 'JOIN ' . $this->room . "\r\n");
        fputs($sock, 'PRIVMSG ' . $this->room . ' :' . $msg . "\r\n");

        while (fgets($sock)) {
            // We don't need to do anything,
            // but the IRC server doesn't appear to post the message
            // unless we wait for responses.
        }

        fclose($sock);

        return true;
    }
}
