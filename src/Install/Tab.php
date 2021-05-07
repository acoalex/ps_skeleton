<?php
/**
 * NOTICE OF LICENSE
 *
 * @author    acoalex, UAB acoalex.com <webmaster@acoalex.com>
 * @copyright Copyright (c) permanent, acoalex, UAB
 * @license   MIT
 * @see       /LICENSE
 *
 *  International Registered Trademark & Property of acoalex, UAB
 */

namespace acoalex\Skeleton\Install;

/**
 * Class Tab - module admin tab settings
 */
class Tab
{
    /**
     * @var string info controller name
     */
    private $controllerInfo = 'AdminSkeletonInfo';
    private $controllerInstall = 'AdminSkeletonInstall';

    /**
     * @var array
     */
    private $configuration;

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return string
     */
    public function getControllerInfo()
    {
        return $this->controllerInfo;
    }

    /**
     * @return string
     */
    public function getControllerInstall()
    {
        return $this->controllerInstall;
    }

    /**
     * @return array
     */
    public function getTabs()
    {
        return isset($this->configuration['tabs']) ? $this->configuration['tabs'] : [];
    }
}
