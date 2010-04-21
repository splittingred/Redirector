<?php
/**
 * @package redirector
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/modredirect.class.php');
class modRedirect_mysql extends modRedirect {}