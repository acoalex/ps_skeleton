<?php
/**
 * NOTICE OF LICENSE
 *
 * @author    acoalex, UAB www.acoalex.com <webmaster@acoalex.com>
 * @copyright Copyright (c) permanent, acoalex, UAB
 * @license   MIT
 * @see       /LICENSE
 *
 *  International Registered Trademark & Property of acoalex, UAB
 */

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use acoalex\Skeleton\Install\Installer;
use acoalex\Skeleton\Install\Tab;
use acoalex\Skeleton\Install\Uninstaller;

class Skeleton extends Module
{
    /**
     * If false, then SkeletonContainer is in immutable state
     */
    const DISABLE_CACHE = true;
    const CONFIG_VARS_KEYS = ["title", "avatar"];

    /**
     * @var SkeletonContainer
     */
    private $moduleContainer;
    public $template_dir;

    public function __construct()
    {
        $this->tab = 'other_modules';
        $this->name = 'skeleton';
        $this->version = '1.0.0';
        $this->author = 'acoalex';

        parent::__construct();
        $this->autoLoad();
        $this->compile();
        $this->displayName = $this->l('Skeleton');
        $this->description = $this->l('This is module description');
        $this->template_dir = '../../../../modules/' . $this->name . '/views/templates/admin/';
    }

    public function getTabs()
    {
        /** @var Tab $tab */
        $tab = $this->getContainer()->get('install.tab');
        return $tab->getTabs();
    }

    public function getContent()
    {
        /** @var Tab $tab */
        $tab = $this->getContainer()->get('install.tab');

        $redirectLink = $this->context->link->getAdminLink($tab->getControllerInfo());
        Tools::redirectAdmin($redirectLink);
    }

    public function install()
    {
        /** @var Installer $installer */
        $installer = $this->getContainer()->get('installer');

        return parent::install() && $installer->init();
    }

    public function uninstall()
    {
        /** @var Uninstaller $unInstaller */
        $unInstaller = $this->getContainer()->get('uninstaller');

        return parent::uninstall() && $unInstaller->init();
    }

    public function hookActionDispatcherBefore()
    {
        $this->autoLoad();
    }

    /**
     * Gets container with loaded classes defined in src folder
     *
     * @return SkeletonContainer
     */
    public function getContainer(): ContainerInterface
    {
        return $this->moduleContainer;
    }

    /**
     * Autoload's project files from /src directory
     */
    private function autoLoad()
    {
        $autoLoadPath = $this->getLocalPath() . 'vendor/autoload.php';

        require_once $autoLoadPath;
    }

    /**
     * Creates compiled dependency injection container which holds data configured in config/config.yml file.
     *
     * @throws Exception
     */
    private function compile()
    {
        $containerCache = $this->getLocalPath() . 'var/cache/container.php';
        $containerConfigCache = new ConfigCache($containerCache, self::DISABLE_CACHE);

        $containerClass = get_class($this) . 'Container';

        if (!$containerConfigCache->isFresh()) {
            $containerBuilder = new ContainerBuilder();
            $locator = new FileLocator($this->getLocalPath() . '/config');
            $loader = new YamlFileLoader($containerBuilder, $locator);
            $loader->load('config.yml');
            $containerBuilder->compile();
            $dumper = new PhpDumper($containerBuilder);

            $containerConfigCache->write(
                $dumper->dump(['class' => $containerClass]),
                $containerBuilder->getResources()
            );
        }

        require_once $containerCache;
        $this->moduleContainer = new $containerClass();
    }

    public function getConfig($key)
    {
        $config = $this->getConfigVars();
        return (array_key_exists($key, $config)) ? $config[$key] : null;
    }

    public function getConfigVars()
    {
        $configVars = [];
        foreach (Skeleton::CONFIG_VARS_KEYS as $key) {
            $configVars[$key] = Configuration::get($this->name . "_" . $key);
        }

        return $configVars;
    }
}
