<?php
/**
 * Loads the home page.
 *
 * @package redirector
 * @subpackage controllers
 */
$modx->regClientStartupScript($redirector->config['jsUrl'].'mgr/widgets/redirects.grid.js');
$modx->regClientStartupScript($redirector->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($redirector->config['jsUrl'].'mgr/sections/index.js');

$output = '<div id="redirector-panel-home-div"></div>';

return $output;
