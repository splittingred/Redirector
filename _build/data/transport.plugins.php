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

return $plugins;