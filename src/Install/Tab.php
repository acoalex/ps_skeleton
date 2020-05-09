<?php
/**
 * NOTICE OF LICENSE
 *
 * @author    veiss, UAB www.veiss.eu <support@veiss.eu>
 * @copyright Copyright (c) permanent, veiss, UAB
 * @license   MIT
 * @see       /LICENSE
 *
 *  International Registered Trademark & Property of veiss, UAB
 */

namespace veiss\Skeleton\Install;

/**
 * Class Tab - module admin tab settings
 */
class Tab
{
    /**
     * @var string info controller name
     */
    private $controllerInfo = 'AdminSkeletonInfo';

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
     * @return array
     */
    public function getTabs()
    {
        return isset($this->configuration['tabs']) ? $this->configuration['tabs'] : [];
    }
}
