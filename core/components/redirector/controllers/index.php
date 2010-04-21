<?php
/**
 * @package redirector
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)).'/model/redirector/redirector.class.php';
$redirector = new Redirector($modx);
return $redirector->initialize('mgr');