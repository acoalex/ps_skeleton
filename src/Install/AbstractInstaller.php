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

use Db;
use Exception;

abstract class AbstractInstaller
{
    /**
     * @return bool
     */
    abstract public function init();

    /**
     * used to parse sql files, replace variables and prepare for execution
     *
     * @param string $fileName
     * @return string
     */
    abstract protected function getSqlStatements($fileName);

    /**
     * Gets current file name. Used for translations
     *
     * @param string $classInstance
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    protected function getFileName($classInstance)
    {
        $reflection = new \ReflectionClass($classInstance);
        return $reflection->getShortName();
    }

    /**
     * Executes sql statements
     *
     * @param Db $database
     * @param string $sqlStatements
     *
     * @return bool
     * @throws Exception
     */
    protected function execute(Db $database, $sqlStatements)
    {
        try {
            $result = $database->execute($sqlStatements);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }
}
