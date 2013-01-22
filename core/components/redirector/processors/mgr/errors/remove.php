<?php
/**
 * @package redirector
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('redirector.redirect_err_ns'));
$redirect = $modx->getObject('modRedirectPageNotFound',$scriptProperties['id']);
if (empty($redirect)) return $modx->error->failure($modx->lexicon('redirector.redirect_err_nf'));

/* remove */
if ($redirect->remove() == false) {
    return $modx->error->failure($modx->lexicon('redirector.redirect_err_remove'));
}

return $modx->error->success('',$redirect);