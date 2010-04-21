<?php
/**
 * Loads the header for mgr pages.
 *
 * @package redirector
 * @subpackage controllers
 */
$modx->regClientStartupScript($redirector->config['jsUrl'].'mgr/redirector.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    Redi.config = '.$modx->toJSON($redirector->config).';
    Redi.config.connector_url = "'.$redirector->config['connectorUrl'].'";
    Redi.request = '.$modx->toJSON($_GET).';
});
</script>');


return '';