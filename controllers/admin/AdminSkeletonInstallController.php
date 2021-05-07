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

/**
 * Class AdminSkeletonInfoController - used for information display for module
 */
class AdminSkeletonInstallController extends \acoalex\Skeleton\Controller\AdminController
{
    private $templateFile;

    public function initContent()
    {
        $form = $this->renderForm();
        $this->templateFile = $this->module->template_dir . 'install.tpl';

        $this->setTemplate($this->templateFile);
    }

}
