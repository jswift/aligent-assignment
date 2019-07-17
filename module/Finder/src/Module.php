<?php
/**
 * Object Finder (The assignment of coding challenge for Aligent Consulting
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder;

/**
 * The definition of the current module
 *
 * @since      Class available since 10 July 2019
 */
class Module
{
    const VERSION = '1.0.0-dev';

    /**
     * Get configured values from the config file of the current module
     *
     * @return mixed
     */
    public function getConfig()
    {
        //return include __DIR__ . '/../config/module.config.php';
        $config = array();
        $configFiles = array(
            include __DIR__ . '/../config/module.config.php',
            include __DIR__ . '/../config/module.customconfig.php',
        );
        foreach ($configFiles as $file) {
            $config = array_merge($config, $file);
        }
        return $config;
    }
}
