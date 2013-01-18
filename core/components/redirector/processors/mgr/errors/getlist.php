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
$limit = $modx->getOption('limit',$_REQUEST,20);
$sort = $modx->getOption('sort',$_REQUEST,'times');
$dir = $modx->getOption('dir',$_REQUEST,'DESC');
$query = $modx->getOption('query',$_REQUEST,'');

/* build query */
$c = $modx->newQuery('modRedirectPageNotFound');

if (!empty($query)) {
    $c->where(array(
        'url:LIKE' => '%'.$query.'%',
    ));
}

$count = $modx->getCount('modRedirectPageNotFound',$c);
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$redirects= $modx->getCollection('modRedirectPageNotFound', $c);

/* iterate */
$list = array();
foreach ($redirects as $redirect) {

    // Format dates
    $a = $redirect->toArray();
    $a['firsttime'] = strftime('%c', $a['firsttime']);
    $a['lasttime'] = strftime('%c', $a['lasttime']);

    $redirectArray = $a;

    $redirectArray['menu'][] = array(
        'text' => $modx->lexicon('redirector.create_rule'),
        'handler' => 'this.createRedirectPageNotFound',
    );

    $redirectArray['menu'][] = '-';

    $redirectArray['menu'][] = array(
        'text' => $modx->lexicon('redirector.remove_page_not_found'),
        'handler' => 'this.removeRedirectPageNotFound',
    );


    $list[]= $redirectArray;
}
return $this->outputArray($list,$count);