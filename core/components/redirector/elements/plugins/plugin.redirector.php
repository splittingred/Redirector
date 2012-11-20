<?php
/**
 * @package redirector
 */

/* load redirector class */
$corePath =  $modx->getOption('redirector.core_path',$scriptProperties,$modx->getOption('core_path').'components/redirector/');
$redirector = $modx->getService('redirector','Redirector',$corePath.'model/redirector/',$scriptProperties);
if (!($redirector instanceof Redirector)) return '';

switch ($modx->event->name) {
    case 'OnPageNotFound':    
        $search = $_SERVER['REQUEST_URI'];
        $baseUrl = $modx->getOption('base_url',null,MODX_BASE_URL);
        if (!empty($baseUrl) && $baseUrl != '/' && $baseUrl != ' ') {
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
        break;
    case 'OnDocFormRender':
        if ($mode == 'upd')
            $_SESSION['modx_resource_alias'] = $resource->get('alias');
        break;
    case 'OnDocFormSave':
        /* if alias has changed, add to redirects */  
        $on_alias_update = $modx->getOption('redirector.on_alias_update',null,'No');
        $new_alias = $resource->get('alias');
        
        if ($mode == 'upd' && $on_alias_update == 'Yes') {            
            $old_alias = $_SESSION['modx_resource_alias'];            
            if ($old_alias != $new_alias) {
                /* alias changed */
                $redirect = $modx->getObject('modRedirect', array('pattern' => $old_alias, 'active' => 1));  
                if (empty($redirect)) {
                    /* no record for old alias */
                    $new_redirect = $modx->newObject('modRedirect');        
                    $new_redirect->fromArray(array('pattern' => $old_alias, 'target' => $new_alias, 'active' => 1));

                    if ($new_redirect->save() == false) {
                        return $modx->error->failure($modx->lexicon('redirector.redirect_err_save'));
                    }
                }
            }
        }
        
        $_SESSION['modx_resource_alias'] = $new_alias;
        break;
}

return;