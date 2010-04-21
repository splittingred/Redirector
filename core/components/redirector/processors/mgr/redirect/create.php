<?php
/**
 * @package redirector
 * @subpackage processors
 */
$redirect = $modx->newObject('modRedirect');
$redirect->fromArray($scriptProperties);

/* save */
if ($redirect->save() == false) {
    return $modx->error->failure($modx->lexicon('redirector.redirect_err_save'));
}


return $modx->error->success('',$redirect);