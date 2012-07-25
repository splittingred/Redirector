<?php
/**
 * @package redirector
 * @subpackage processors
 */
class RedirectorRemoveProcessor extends modObjectRemoveProcessor {
    /** @var modRedirect $object */
    public $object;
    public $classKey = 'modRedirect';
    public $languageTopics = array('redirector:default');
    public $objectType = 'redirector.modredirect';
}
return 'RedirectorRemoveProcessor';
