<?php
/**
 * @package redirector
 * @subpackage build
 */
$plugins = array();

$plugins[1]= $modx->newObject('modSnippet');
$plugins[1]->fromArray(array(
    'id' => 1,
    'name' => 'Redirector',
    'description' => 'Handles site redirects.',
    'plugincode' => getSnippetContent($sources['elements'].'snippets/snippet.redirector.php'),
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