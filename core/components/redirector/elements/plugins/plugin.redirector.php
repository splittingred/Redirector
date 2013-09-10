<?php
/**
 * @package redirector
 */
/* load redirector class */
$corePath =  $modx->getOption('redirector.core_path',$scriptProperties,$modx->getOption('core_path').'components/redirector/');
$redirector = $modx->getService('redirector','Redirector',$corePath.'model/redirector/',$scriptProperties);
if (!($redirector instanceof Redirector)) return '';

/* handle redirects */
$search = $_SERVER['REQUEST_URI'];
$baseUrl = $modx->getOption('base_url',null,MODX_BASE_URL);
if (!empty($baseUrl) && $baseUrl != '/' && $baseUrl != ' ' && $baseUrl != '/'.$modx->context->get('key').'/') {
    $search = str_replace($baseUrl,'',$search);
}
$search = ltrim($search,'/');
$extPos = strrpos($search, '.');
if ($extPos) {
    if ($search) {
        $redirect = $modx->getObject('modRedirect', array(
            'pattern' => $search,
            'active' => 1,
        ));
        if ($redirect) {
            $target = $redirect->get('target');
            $modx->parser->processElementTags('', $target, true, true);
            if ($target != $modx->resourceIdentifier && $target != $search) {
                if (!strpos($target, '://')) {
                    $target = $modx->getOption('site_url').$target;
                }
                $modx->log(modX::LOG_LEVEL_INFO, 'Redirector plugin redirecting request for ' . $search . ' to ' . $target);
                header('HTTP/1.1 301 Moved Permanently');
                $modx->sendRedirect($target);
            }
        }
    }
    $search = substr($search, 0, $extPos);
}
if ($search) {
    $redirect = $modx->getObject('modRedirect', array('pattern' => $search, 'active' => 1));
    if ($redirect) {
        $target = $redirect->get('target');
        $modx->parser->processElementTags('', $target, true, true);
        if ($target != $modx->resourceIdentifier && $target != $search) {
            if (!strpos($target, '://')) {
                $target = $modx->getOption('site_url').$target;
            }
            $modx->log(modX::LOG_LEVEL_INFO, 'Redirector plugin redirecting request for ' . $search . ' to ' . $target);
            header('HTTP/1.1 301 Moved Permanently');
            $modx->sendRedirect($target);
        }
    }
}
return;
