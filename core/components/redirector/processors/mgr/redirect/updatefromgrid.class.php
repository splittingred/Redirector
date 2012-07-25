<?php
/**
 * @package redirector
 * @subpackage processors
 */
require_once (dirname(__FILE__).'/update.class.php');
class RedirectorUpdateFromGridProcessor extends RedirectorUpdateProcessor {
    public function initialize() {
        $data = $this->modx->fromJSON($this->getProperty('data'));
        if (!is_array($data)) return $this->modx->error->failure('Invalid data.');
        $this->setProperties($data);
        $this->unsetProperty('data');

        return parent::initialize();
    }
}
return 'RedirectorUpdateFromGridProcessor';
