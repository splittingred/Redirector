<?php
/**
 * @package redirector
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('redirector.redirect_err_ns'));
$redirect = $modx->getObject('modRedirect',$scriptProperties['id']);
if (empty($redirect)) return $modx->error->failure($modx->lexicon('redirector.redirect_err_nf'));

/* set fields */
$redirect->fromArray($scriptProperties);

/* save */
if ($redirect->save() == false) {
    return $modx->error->failure($modx->lexicon('redirector.redirect_err_save'));
}


return $modx->error->success('',$redirect);