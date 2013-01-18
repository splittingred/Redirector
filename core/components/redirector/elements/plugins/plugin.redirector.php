<?php


/**
 * @package redirector
 */
/* load redirector class */
$corePath =  $modx->getOption('redirector.core_path',$scriptProperties,$modx->getOption('core_path').'components/redirector/');
$redirector = $modx->getService('redirector','Redirector',$corePath.'model/redirector/',$scriptProperties);
if (!($redirector instanceof Redirector)) return '';


switch($modx->event->name){
    case 'OnPageNotFound':
        /* handle redirects */
        $search = $_SERVER['REQUEST_URI'];
        $originalRequest = $search;
        $baseUrl = $modx->getOption('base_url',null,MODX_BASE_URL);
        if (!empty($baseUrl) && $baseUrl != '/' && $baseUrl != ' ') {
            $search = str_replace($baseUrl,'',$search);
            $originalRequest = $search;
        }
        $search = ltrim($search,'/');

        $extPos = strrpos($search, '.');

        if ($extPos) {
            if ($search) {
                $redirector->getRedirect($search);
            }
            $search = substr($search, 0, $extPos);
        }
        if ($search) {
            $redirector->getRedirect($search);
        }

        $redirector->record404($originalRequest);
        return;
    break;
    case 'OnSiteRefresh':
        $redirector->clearRedirectCache();
        return;
        break;
}
