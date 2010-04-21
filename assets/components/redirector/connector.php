<?php
/**
 * Redirector Connector
 *
 * @package redirector
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('redirector.core_path',null,$modx->getOption('core_path').'components/redirector/');
require_once $corePath.'model/redirector/redirector.class.php';
$modx->redirector = new Redirector($modx);

$modx->lexicon->load('redirector:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->redirector->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));