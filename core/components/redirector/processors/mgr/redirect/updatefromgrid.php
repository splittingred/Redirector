<?php
/**
 * @package redirector
 * @subpackage processors
 */
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Invalid data.');

/* get obj */
if (empty($_DATA['id'])) return $modx->error->failure($modx->lexicon('redirector.redirect_err_ns'));
$redirect = $modx->getObject('modRedirect',$_DATA['id']);
if (empty($redirect)) return $modx->error->failure($modx->lexicon('redirector.redirect_err_nf'));

$redirect->fromArray($_DATA);

/* save */
if ($redirect->save() == false) {
    return $modx->error->failure($modx->lexicon('redirector.redirect_err_save'));
}


return $modx->error->success('',$redirect);