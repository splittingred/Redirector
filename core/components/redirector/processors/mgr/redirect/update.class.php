<?php
/**
 * @package redirector
 * @subpackage processors
 */
class RedirectorUpdateProcessor extends modObjectUpdateProcessor {
    /** @var modRedirect $object */
    public $object;
    public $classKey = 'modRedirect';
    public $languageTopics = array('redirector:default');
    public $objectType = 'redirector.modredirect';

    public function beforeSet() {
        /* put checkbox to 0 if not present in the array */
        if (!array_key_exists('active', $this->properties)) {
            $this->setProperty('active', '0');
        }
        return parent::beforeSet();
    }
}
return 'RedirectorUpdateProcessor';
