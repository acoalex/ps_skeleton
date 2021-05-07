<?php
/**
 * NOTICE OF LICENSE
 *
 * @author    acoalex, UAB www.acc.eu <webmaster@acoalex.com>
 * @copyright Copyright (c) permanent, acc, UAB
 * @license   MIT
 * @see       /LICENSE
 *
 *  International Registered Trademark & Property of acc, UAB
 */

namespace acoalex\Skeleton\Services;

class LogService extends \FileLoggerCore

{
    /* LEVELS
    0 => 'DEBUG',
    1 => 'INFO',
    2 => 'WARNING',
    3 => 'ERROR',
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function init($modulename, $filename = "")
    {
        $this->setFilename(_PS_MODULE_DIR_ . $modulename . '/log/' . date('Ymd') . '_' . $modulename . $filename . '.log');
    }

    public function getHello()
    {
        return "Hello";
    }

    public function logMessage($message, $level = 1)
    {
        if (!is_string($message)) {
            $message = print_r($message, true);
        }
        $formatted_message = '*' . $this->level_value[$level] . '* ' . "\tv" . _PS_VERSION_ . "\t" . date('Y/m/d - H:i:s') . ': ' . $message . "\r\n";

        return (bool) file_put_contents($this->getFilename(), $formatted_message, FILE_APPEND);
    }
}
