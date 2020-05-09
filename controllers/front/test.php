<?php

class SkeletonTestModuleFrontController extends \ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
    }

    public function initContent()
    {
        $this->setTemplate('module:skeleton/views/templates/front/test.tpl');
    }
}
