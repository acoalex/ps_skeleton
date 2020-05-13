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

use Configuration;
use Db;
use Exception;
use Tools;

/**
 * Class Installer - responsible for module installation process
 */
class Installer extends AbstractInstaller
{
    /**
     * @var \Skeleton
     */
    private $module;
    /**
     * @var array
     */
    private $configuration;

    /**
     * @param \Skeleton $module
     * @param array $configuration
     */
    public function __construct(\Skeleton $module, array $configuration)
    {
        $this->module = $module;
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!$this->registerHooks()) {
            return false;
        }

        if (!$this->installConfiguration()) {
            return false;
        }

        if (!$this->installDb()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getSqlStatements($fileName)
    {
        $sqlStatements = Tools::file_get_contents($fileName);
        $sqlStatements = str_replace(['PREFIX_', 'ENGINE_TYPE'], [_DB_PREFIX_, _MYSQL_ENGINE_], $sqlStatements);

        return $sqlStatements;
    }

    /**
     * @return bool
     *
     * @throws \Exception
     */
    private function registerHooks()
    {
        $hooks = $this->configuration['hooks'];

        if (empty($hooks)) {
            return true;
        }

        foreach ($hooks as $hookName) {
            if (!$this->module->registerHook($hookName)) {
                throw new Exception(
                    sprintf(
                        $this->module->l('Hook %s has not been installed.', $this->getFileName($this)),
                        $hookName
                    )
                );
            }
        }

        return true;
    }

    /**
     * Installs global settings
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function installConfiguration()
    {
        $configuration = $this->configuration['configuration'];
        if (empty($configuration)) {
            return true;
        }

        foreach ($configuration as $index => $element) {
            foreach ($element as $name => $value) {

                if (!Configuration::updateValue($this->module->name . "_" . $name, $value)) {
                    throw new Exception(
                        sprintf(
                            $this->module->l('Configuration %s has not been installed.', $this->getFileName($this)),
                            $name
                        )
                    );
                }
            }
        }

        return true;
    }

    /**
     * Reads sql files and executes
     *
     * @return bool
     * @throws Exception
     */
    private function installDb()
    {
        $installSqlFiles = glob($this->module->getLocalPath() . 'sql/install/*.sql');

        if (empty($installSqlFiles)) {
            return true;
        }

        $database = Db::getInstance();

        foreach ($installSqlFiles as $sqlFile) {
            $sqlStatements = $this->getSqlStatements($sqlFile);

            try {
                $this->execute($database, $sqlStatements);
            } catch (Exception $exception) {
                throw new Exception($exception->getMessage());
            }
        }

        return true;
    }
}
