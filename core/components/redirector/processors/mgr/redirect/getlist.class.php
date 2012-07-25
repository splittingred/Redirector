<?php
/**
 * Get a list of Redirects
 *
 * @package redirector
 * @subpackage processors
 */
class RedirectorGetListProcessor extends modObjectGetListProcessor {
    /** @var modRedirect $object */
    public $object;
    public $classKey = 'modRedirect';
    public $languageTopics = array('redirector:default');
    public $defaultSortField = 'pattern';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'redirector.modredirect';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'pattern:LIKE' => '%'.$query.'%',
            ));
            $c->orCondition(array(
                'target:LIKE' => '%'.$query.'%',
            ));
        }

        return $c;
    }

    public function prepareRow(xPDOObject $object) {
        $objectArray = $object->toArray();

        $objectArray['menu'] = array();
        $objectArray['menu'][] = array(
            'text' => $this->modx->lexicon('redirector.redirect_update'),
            'handler' => 'this.updateRedirect',
        );
        $objectArray['menu'][] = '-';
        $objectArray['menu'][] = array(
            'text' => $this->modx->lexicon('redirector.redirect_remove'),
            'handler' => 'this.removeRedirect',
        );

        return $objectArray;
    }
}
return 'RedirectorGetListProcessor';
