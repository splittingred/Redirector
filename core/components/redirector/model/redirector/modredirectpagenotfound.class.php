<?php
/**
 * @package redirector
 */
class modRedirectPageNotFound extends xPDOSimpleObject {
    function modRedirectPageNotFound(& $xpdo) {
        $this->__construct($xpdo);
    }
    function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }
}
?>