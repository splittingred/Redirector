<?php
/**
 * @package redirector
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('redirector.redirect_err_ns'));
$redirect = $modx->getObject('modRedirectPageNotFound',$scriptProperties['id']);
if (empty($redirect)) return $modx->error->failure($modx->lexicon('redirector.redirect_err_nf'));

/* put checkbox to 0 if not present in the array */
if(!array_key_exists('visible', $scriptProperties))
    $scriptProperties['visible'] = '0';

/* set fields */
$redirect->fromArray($scriptProperties);

/* save */
if ($redirect->save() == false) {

    return $modx->error->failure($modx->lexicon('redirector.redirect_err_save'));
}


return $modx->error->success('',$redirect);