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

/**
 * Class AdminSkeletonInfoController - used for information display for module
 */
class AdminSkeletonInstallController extends \veiss\Skeleton\Controller\AdminController
{
    private $templateFile;

    public function initContent()
    {
        $form = $this->renderForm();
        $this->templateFile = $this->module->template_dir . 'install.tpl';

        $this->setTemplate($this->templateFile);
    }

}
