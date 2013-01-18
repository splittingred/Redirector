<?php
/**
 * @package redirector
 */
class modRedirect extends xPDOSimpleObject {
    function modRedirect(& $xpdo) {
        $this->__construct($xpdo);
    }
    function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    function save(){
        $this->xpdo->cacheManager->refresh(array('Redirector' => array()));
        return parent::save();
    }
}
?>