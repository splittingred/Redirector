<?php
/**
 * @package redirector
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/modredirectpagenotfound.class.php');
class modRedirectPageNotFound_mysql extends modRedirectPageNotFound {
    function modRedirectPageNotFound_mysql(& $xpdo) {
        $this->__construct($xpdo);
    }
    function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }
}
?>