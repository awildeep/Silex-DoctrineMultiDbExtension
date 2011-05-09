Doctrine Multiple DB Extension for Silex
========================================

This extension can be used if you need to access multiple databases via Silex.


Installation
------------

Include the extension into your Silex project (directory may very):

    include_once __DIR__ . '/vendor/Silex/Extension/DoctrineMultiDbExtension.php';

Download the Doctrine2 DBAL and Common libraries.  The examples below assume they will be in:

    ApplicationRoot/vendor/doctrine-dbal/lib

    and

    ApplicationRoot/vendor/doctrine-common/lib


Configuration/Register the extension
------------------------------------

Configure a sqlite and a MySQL database:

    $app->register(new Silex\Extension\DoctrineMultiDbExtension(),
    array(
        'doctrine_multi_db.dbs' => array (
            'db.sqlite' => array(
                'driver'    => 'pdo_sqlite',
                'path'      => __DIR__.'/db/app.sqlite',
            ),
            'db.mysql' => array(
                'dbname' => 'mydb',
                'user' => 'user',
                'password' => 'my_secret_password',
                'host' => 'localhost',
                'driver' => 'pdo_mysql',
            ),
         ),

        'doctrine_multi_db.dbal.class_path'   =>
                __DIR__.'/vendor/doctrine-dbal/lib',
        'doctrine_multi_db.common.class_path' =>
                __DIR__.'/vendor/doctrine-common/lib',
    ));

You can simply add more databases in order to provide support for separate read/write/report DBs:

    $app->register(new Silex\Extension\DoctrineMultiDbExtension(),
    array(
        'doctrine_multi_db.dbs' => array (
            'db.pg_read' => array(
                'dbname' => 'mypgdb',
                'user' => 'user',
                'password' => 'my_secret_password',
                'host' => 'readable.mydomain.tld',
                'driver' => 'pdo_pgsql',
            ),
            'db.pg_write' => array(
                'dbname' => 'mypgdb',
                'user' => 'user',
                'password' => 'my_secret_password',
                'host' => 'writable.mydomain.tld',
                'driver' => 'pdo_pgsql',
            ),
            'db.pg_report' => array(
                'dbname' => 'mypgdb',
                'user' => 'user',
                'password' => 'my_secret_password',
                'host' => 'reporting.mydomain.tld',
                'driver' => 'pdo_pgsql',
            ),
         ),

        'doctrine_multi_db.dbal.class_path'   =>
                __DIR__.'/vendor/doctrine-dbal/lib',
        'doctrine_multi_db.common.class_path' =>
                __DIR__.'/vendor/doctrine-common/lib',
    ));

This second example would be useful if you could only write to one database node, report from another, and read from a
third (this is a common situation in replicated database environments).

Ultimately, you should be able to have as many DB connections as you need.


Suggestions/Comments/TODO
-------------------------

* I may make the configuration options more like the Silex/Extensions/DoctrineExtension
    * I do however like how verbose this is, and you can technically use both extensions this way
* Need to test multiple connections more and try to bre

Credits
-------
Fabien Potencier, he wrote the code this extension is based off of.
Igor Wiedler, for helping me get my environment working.
Greg Militello, the guy who hobbled this code together. 


License
-------
Not currently released with a license, until I talk to some folks.  Probably the same lisence as Silex for
compatibility.