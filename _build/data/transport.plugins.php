<?php
/**
 * @package redirector
 * @subpackage build
 */
$plugins = array();

$plugins[1]= $modx->newObject('modPlugin');
$plugins[1]->fromArray(array(
    'id' => 1,
    'name' => 'Redirector',
    'description' => 'Handles site redirects.',
    'plugincode' => file_get_contents($sources['elements'].'plugins/plugin.redirector.php'),
),'',true,true);
    $events = array();
    $events['OnPageNotFound']= $modx->newObject('modPluginEvent');
    $events['OnPageNotFound']->fromArray(array(
        'event' => 'OnPageNotFound',
        'priority' => 0,
        'propertyset' => 0,
    ),'',true,true);
    $plugins[1]->addMany($events);
    unset($events);

return $plugins;