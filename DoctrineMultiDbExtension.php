<?php
/**
 * Multiple Database Extension for Silex.
 *
 * Based on the Silex/DoctrineExtension from Fabien Potencier <fabien@symfony.com>
 *
 * @author Greg Militello <junk@thinkof.net>
 *
 */
namespace Silex\Extension;

use Silex\Application;
use Silex\ExtensionInterface;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use Doctrine\Common\EventManager;

class DoctrineMultiDbExtension implements ExtensionInterface
{
    public function register(Application $app) {
        //Register each of the databases in the configuration
        foreach ($app['doctrine_multi_db.dbs'] as $connectionName => $connectionOptions) {
            $app[$connectionName] = $app->share(function () use($app, $connectionOptions, $connectionName) {
                return DriverManager::getConnection($connectionOptions, $app[$connectionName.'.config'], $app[$connectionName.'.event_manager']);
            });
            $app[$connectionName.'.config'] = $app->share(function () {
                return new Configuration();
            });

            $app[$connectionName.'.event_manager'] = $app->share(function () {
                return new EventManager();
            });
        }

        //autoload Doctrine DBAL
        if (isset($app['doctrine_multi_db.dbal.class_path'])) {
            $app['autoloader']->registerNamespace('Doctrine\\DBAL', $app['doctrine_multi_db.dbal.class_path']);
        }
        //autoload Doctrine Common
        if (isset($app['doctrine_multi_db.common.class_path'])) {
            $app['autoloader']->registerNamespace('Doctrine\\Common', $app['doctrine_multi_db.common.class_path']);
        }
    }
}
