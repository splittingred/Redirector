<?php
/**
 * @package redirector
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/modredirect.class.php');
class modRedirect_sqlsrv extends modRedirect {
    function modRedirect_sqlsrv(& $xpdo) {
        $this->__construct($xpdo);
    }
    function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }
}
?>