<?php
/**
 * Resolve creating custom db tables during install.
 *
 * @package redirector
 * @subpackage build
 */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('redirector.core_path',null,$modx->getOption('core_path').'components/redirector/').'model/';
            $modx->addPackage('redirector',$modelPath);

            $manager = $modx->getManager();

            $manager->createObjectContainer('modRedirect');

            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
}
return true;