<?php
/**
 * Build Schema script
 *
 * @package redirector
 * @subpackage build
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

define('PKG_NAME','Redirector');
define('PKG_NAME_LOWER','redirector');

require_once dirname(__FILE__).'/build.config.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';
require_once dirname(__FILE__).'/build.properties.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);
echo '<pre>'; /* used for nice formatting of log messages */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root,
    'core' => $root.'core/components/redirector/',
    'model' => $root.'core/components/redirector/model/',
    'schema' => $root.'core/components/redirector/model/schema/',
    'schema_file' => $root.'core/components/redirector/model/schema/redirector.mysql.schema.xml',
    'assets' => $root.'assets/components/redirector/',
);
foreach (array('mysql', 'sqlsrv') as $driver) {
    $xpdo= new xPDO(
        $properties["{$driver}_string_dsn_nodb"],
        $properties["{$driver}_string_username"],
        $properties["{$driver}_string_password"],
        $properties["{$driver}_array_options"],
        $properties["{$driver}_array_driverOptions"]
    );
    $xpdo->setPackage('modx', dirname(XPDO_CORE_PATH) . '/model/');
    $xpdo->setDebug(true);

    $manager= $xpdo->getManager();
    $generator= $manager->getGenerator();

    $manager= $xpdo->getManager();
    $generator= $manager->getGenerator();

$generator->classTemplate= <<<EOD
<?php
/**
 * [+phpdoc-package+]
 */
class [+class+] extends [+extends+] {
    function [+class+](& \$xpdo) {
        \$this->__construct(\$xpdo);
    }
    function __construct(& \$xpdo) {
        parent :: __construct(\$xpdo);
    }
}
?>
EOD;
$generator->platformTemplate= <<<EOD
<?php
/**
 * [+phpdoc-package+]
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\\\', '/') . '/[+class-lowercase+].class.php');
class [+class+]_[+platform+] extends [+class+] {
    function [+class+]_[+platform+](& \$xpdo) {
        \$this->__construct(\$xpdo);
    }
    function __construct(& \$xpdo) {
        parent :: __construct(\$xpdo);
    }
}
?>
EOD;
$generator->mapHeader= <<<EOD
<?php
/**
 * [+phpdoc-package+]
 */
EOD;
    $generator->parseSchema($sources['model'] . 'schema/'.PKG_NAME_LOWER.'.'.$driver.'.schema.xml', $sources['model']);
}


$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

echo "\nExecution time: {$totalTime}\n";

exit ();