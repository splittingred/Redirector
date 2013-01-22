<?php
/**
 * Get a list of Redirects
 *
 * @package redirector
 * @subpackage processors
 */
/* setup default properties */
$isLimit = !empty($_REQUEST['limit']);
$start = $modx->getOption('start',$_REQUEST,0);
$limit = $modx->getOption('limit',$_REQUEST,0);
$sort = $modx->getOption('sort',$_REQUEST,'sortorder');
$dir = $modx->getOption('dir',$_REQUEST,'ASC');
$query = $modx->getOption('query',$_REQUEST,'');

/* build query */
$c = $modx->newQuery('modRedirect');

if (!empty($query)) {
    $c->where(array(
        'pattern:LIKE' => '%'.$query.'%',
    ));
    $c->orCondition(array(
        'target:LIKE' => '%'.$query.'%',
    ));
}

$count = $modx->getCount('modRedirect',$c);
$c->sortby($sort,$dir);
//if ($isLimit) $c->limit($limit,$start); //Ignore the limit
$redirects= $modx->getCollection('modRedirect', $c);

/* iterate */
$list = array();
foreach ($redirects as $redirect) {
    $redirectArray = $redirect->toArray();

    $redirectArray['menu'] = array();
    $redirectArray['menu'][] = array(
        'text' => $modx->lexicon('redirector.redirect_update'),
        'handler' => 'this.updateRedirect',
    );
    $redirectArray['menu'][] = '-';
    $redirectArray['menu'][] = array(
        'text' => $modx->lexicon('redirector.redirect_remove'),
        'handler' => 'this.removeRedirect',
    );

    $list[]= $redirectArray;
}
return $this->outputArray($list,$count);