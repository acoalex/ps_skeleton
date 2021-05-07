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

namespace acoalex\Skeleton\Controller;

/**
 * Class AdminController - an abstraction for all admin controllers
 */
class AdminController extends \ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
    }
}
